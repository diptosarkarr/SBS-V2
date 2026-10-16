<?php
/**
 * Plugin Name:       SBS Pricing Cards (Shortcode)
 * Description:       Server-side rendered pricing cards sourced live from the Proposal OS Pricing Sheet, replacing the old cross-origin iframe embed so the content appears in the page source (crawlable / SEO-friendly). Everything fetched is sanitized before it is printed.
 * Version:           1.1.0
 * Author:            Sites by Sara
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * License:           GPL-2.0-or-later
 * Text Domain:       sbs-pricing-cards
 *
 * USAGE (Elementor "Shortcode" widget, an HTML widget, or any post/page content):
 *   [sbs_pricing_cards ids="19|134,20,22" popular="19" title="WordPress Hosting & Maintenance (WHAM) Plans"]
 *
 * Attributes (mirror the old iframe's query params exactly):
 *   ids      (required) comma-separated cards; each card is 1-2 Module IDs joined by "|"
 *            (two ids combine a Monthly + Annual sibling pair into one card showing both prices).
 *   popular  (optional) a Module ID; the card containing it gets the "Most Popular" badge.
 *   title    (optional) small gray label shown above the cards.
 *   button   (optional) Order button text, default "Order Now".
 *   link     (optional) path each Order button points to, default "/configure". Only a path on the
 *            order site (or an https://order.sitesbysara.com URL) is accepted; anything else is
 *            replaced by "/configure".
 *   cache    (optional) minutes to cache the fetched HTML, 5-1440, default 30.
 *
 * HOW IT WORKS:
 *   The WordPress server (never the visitor's browser) fetches the card markup from Proposal OS,
 *   keeps it in a transient, and prints it as real page content. The fetched markup is NOT
 *   trusted: before every print it is passed through an allow-list (wp_kses), its stylesheet is
 *   validated rule by rule, and every link is forced onto the order site. If the order system
 *   changes or is compromised, no script, event handler, iframe, form or foreign link can reach
 *   the page.
 *
 * wp-config.php options (all optional): SBS_PRICING_CARDS_HOST, SBS_PRICING_CARDS_BASE_URL, SBS_PRICING_CARDS_ALLOW_PRIVATE_IP.
 *
 * LAYOUT:
 *   The card grid is 2 columns (1 on phones) on every page; see sbs_pricing_cards_layout_css() to change it.
 *
 * RELIABILITY:
 *   - A cache miss on a page that already has a stale copy never blocks the visitor: the stale
 *     copy is shown and a background WP-Cron job refreshes it (if WP-Cron is disabled the page
 *     refreshes the copy itself instead, so prices cannot go stale).
 *   - The very first render (no copy at all) fetches once, with a short timeout. A failed fetch
 *     is remembered for 60 seconds so a down order system cannot make every page view wait.
 *   - If nothing is available, a plain "Order Now" link is shown instead of an empty block.
 *
 * CACHE REFRESH:
 *   Logged in as an administrator, add ?sbs_pricing_refresh=1 to the page URL to force a fresh
 *   fetch for that one load.
 *
 * INSTALL:
 *   Upload this folder to wp-content/plugins/sbs-pricing-cards/ and activate it from Plugins.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'SBS_PRICING_CARDS_VERSION', '1.1.0' );

// Set any of these in wp-config.php (before plugins load) to point at another environment.
if ( ! defined( 'SBS_PRICING_CARDS_HOST' ) ) {
	define( 'SBS_PRICING_CARDS_HOST', 'order.sitesbysara.com' );
}
if ( ! defined( 'SBS_PRICING_CARDS_BASE_URL' ) ) {
	define( 'SBS_PRICING_CARDS_BASE_URL', 'https://' . SBS_PRICING_CARDS_HOST . '/configure/pricing-cards-fragment' );
}
if ( ! defined( 'SBS_PRICING_CARDS_FALLBACK_URL' ) ) {
	define( 'SBS_PRICING_CARDS_FALLBACK_URL', 'https://' . SBS_PRICING_CARDS_HOST . '/configure' );
}

define( 'SBS_PRICING_CARDS_MAX_BYTES', 150000 );   // largest response we accept
define( 'SBS_PRICING_CARDS_MAX_CSS', 20000 );      // largest stylesheet we accept
define( 'SBS_PRICING_CARDS_STALE_TTL', 7 * DAY_IN_SECONDS );

add_shortcode( 'sbs_pricing_cards', 'sbs_pricing_cards_shortcode' );
add_action( 'sbs_pricing_cards_refresh', 'sbs_pricing_cards_refresh_cache', 10, 3 );
register_deactivation_hook( __FILE__, 'sbs_pricing_cards_deactivate' );

function sbs_pricing_cards_deactivate() {
	wp_unschedule_hook( 'sbs_pricing_cards_refresh' );
}

/* ------------------------------------------------------------------------------------------------
 * Input handling
 * --------------------------------------------------------------------------------------------- */

/** True only for https://<order host>/... (no credentials, default port). */
function sbs_pricing_cards_is_order_url( $url ) {
	$parts = wp_parse_url( (string) $url );
	if ( ! is_array( $parts ) || empty( $parts['scheme'] ) || empty( $parts['host'] ) ) {
		return false;
	}
	if ( 'https' !== strtolower( $parts['scheme'] ) || strtolower( $parts['host'] ) !== strtolower( SBS_PRICING_CARDS_HOST ) ) {
		return false;
	}
	if ( isset( $parts['user'] ) || isset( $parts['pass'] ) ) {
		return false;
	}
	return ! isset( $parts['port'] ) || 443 === (int) $parts['port'];
}

/** The `link` attribute: a plain path on the order site, or an https order URL. Anything else becomes /configure. */
function sbs_pricing_cards_clean_link( $link ) {
	$link = trim( (string) $link );
	if ( '' === $link || strlen( $link ) > 200 || preg_match( '/[\x00-\x20\x7F\\\\]/', $link ) ) {
		return '/configure';
	}
	if ( preg_match( '#^/(?!/)[A-Za-z0-9._~\-/?=&%]*$#', $link ) ) {
		return $link;
	}
	return sbs_pricing_cards_is_order_url( $link ) ? $link : '/configure';
}

/** Build the (validated) fetch URL, or '' when the filtered base URL is not the order site. */
function sbs_pricing_cards_request_url( array $query ) {
	$base = apply_filters( 'sbs_pricing_cards_base_url', SBS_PRICING_CARDS_BASE_URL );
	if ( ! sbs_pricing_cards_is_order_url( $base ) ) {
		$base = SBS_PRICING_CARDS_BASE_URL;
	}
	// http_build_query() encodes values; add_query_arg() does not (a "&" in a title would split it).
	return $base . '?' . http_build_query( $query );
}

/* ------------------------------------------------------------------------------------------------
 * Fetching and caching
 * --------------------------------------------------------------------------------------------- */

/** One short, bounded request. Returns the body, or false for anything unexpected. */
function sbs_pricing_cards_fetch( $request_url ) {
	if ( ! sbs_pricing_cards_is_order_url( $request_url ) ) {
		return false;
	}
	// wp_safe_remote_get() refuses private/loopback addresses. Define SBS_PRICING_CARDS_ALLOW_PRIVATE_IP as true
	// in wp-config.php only if this server reaches the order system over a private network.
	$getter   = ( defined( 'SBS_PRICING_CARDS_ALLOW_PRIVATE_IP' ) && SBS_PRICING_CARDS_ALLOW_PRIVATE_IP ) ? 'wp_remote_get' : 'wp_safe_remote_get';
	$response = $getter(
		$request_url,
		array(
			'timeout'             => 4,
			'redirection'         => 0, // the endpoint never redirects; a redirect is a failure
			'limit_response_size' => SBS_PRICING_CARDS_MAX_BYTES,
			'user-agent'          => 'SBS-Pricing-Cards/' . SBS_PRICING_CARDS_VERSION . '; ' . home_url( '/' ),
			'headers'             => array( 'Accept' => 'text/html' ),
		)
	);
	if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		return false;
	}
	if ( false === stripos( (string) wp_remote_retrieve_header( $response, 'content-type' ), 'text/html' ) ) {
		return false;
	}
	$body = (string) wp_remote_retrieve_body( $response );
	if ( '' === $body || strlen( $body ) >= SBS_PRICING_CARDS_MAX_BYTES || false === strpos( $body, 'pc-wrap' ) ) {
		return false; // empty, truncated, or not the card fragment (error page, captive portal, ...)
	}
	return $body;
}

function sbs_pricing_cards_store( $cache_key, $html, $cache_minutes ) {
	if ( $cache_minutes > 0 ) {
		set_transient( $cache_key, $html, $cache_minutes * MINUTE_IN_SECONDS );
	}
	set_transient( $cache_key . '_stale', $html, SBS_PRICING_CARDS_STALE_TTL ); // last known-good copy
	delete_transient( $cache_key . '_fail' );
}

/** WP-Cron job: refresh one cached block in the background. */
function sbs_pricing_cards_refresh_cache( $request_url, $cache_key, $cache_minutes ) {
	$cache_key = preg_replace( '/[^A-Za-z0-9_]/', '', (string) $cache_key );
	if ( '' === $cache_key || 0 !== strpos( $cache_key, 'sbs_pc_' ) || get_transient( $cache_key . '_lock' ) ) {
		return;
	}
	set_transient( $cache_key . '_lock', 1, 30 );
	$html = sbs_pricing_cards_fetch( $request_url );
	if ( false === $html ) {
		set_transient( $cache_key . '_fail', 1, 60 );
	} else {
		sbs_pricing_cards_store( $cache_key, $html, max( 5, (int) $cache_minutes ) );
	}
	delete_transient( $cache_key . '_lock' );
}

/* ------------------------------------------------------------------------------------------------
 * Sanitizing what the order system returned (done on every print, so a bad cached copy is harmless)
 * --------------------------------------------------------------------------------------------- */

function sbs_pricing_cards_allowed_html() {
	$common = array(
		'class'       => true,
		'aria-hidden' => true,
		'aria-label'  => true,
		'role'        => true,
	);
	$svg_paint = array(
		'fill'            => true,
		'stroke'          => true,
		'stroke-width'    => true,
		'stroke-linecap'  => true,
		'stroke-linejoin' => true,
	);
	return array(
		'div'      => $common,
		'span'     => $common,
		'p'        => $common,
		'ul'       => $common,
		'li'       => $common,
		'strong'   => $common,
		'em'       => $common,
		'br'       => array(),
		'h2'       => $common,
		'h3'       => $common,
		'h4'       => $common,
		'a'        => $common + array( 'href' => true, 'rel' => true ),
		'svg'      => $common + $svg_paint + array( 'xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true, 'focusable' => true ),
		'path'     => $svg_paint + array( 'd' => true ),
		'circle'   => $svg_paint + array( 'cx' => true, 'cy' => true, 'r' => true ),
		'line'     => $svg_paint + array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true ),
		'polyline' => $svg_paint + array( 'points' => true ),
	);
}

/**
 * Accept the stylesheet only if it is plain layout CSS for the card block: every selector starts with
 * .pc-, the only at-rule is @media (max-width/min-width: Npx), and there is nothing that can load
 * resources or run code. Returns the CSS, or '' when anything is off.
 */
function sbs_pricing_cards_clean_css( $css ) {
	$css = preg_replace( '#/\*.*?\*/#s', '', (string) $css );
	$css = trim( (string) $css );
	if ( '' === $css || strlen( $css ) > SBS_PRICING_CARDS_MAX_CSS ) {
		return '';
	}
	if ( preg_match( '/[<\\\\]|@import|@charset|@font-face|@namespace|url\s*\(|image-set\s*\(|expression\s*\(|javascript\s*:|vbscript\s*:|behaviou?r\s*:|binding\s*:|-moz-binding/i', $css ) ) {
		return '';
	}
	// Walk the stylesheet: "selectors { declarations }", optionally wrapped in one @media block.
	$depth    = 0;
	$buffer   = '';
	$in_media = false;
	$length   = strlen( $css );
	for ( $i = 0; $i < $length; $i++ ) {
		$char = $css[ $i ];
		if ( '{' === $char ) {
			$prelude = trim( $buffer );
			$buffer  = '';
			if ( 0 === $depth && 0 === strpos( $prelude, '@' ) ) {
				if ( ! preg_match( '/^@media\s*\(\s*(?:max|min)-width\s*:\s*\d{1,5}px\s*\)$/i', $prelude ) ) {
					return '';
				}
				$in_media = true;
			} else {
				foreach ( explode( ',', $prelude ) as $selector ) {
					$selector = trim( $selector );
					if ( ! preg_match( '/^\.pc-[A-Za-z0-9_\-]*(?:[A-Za-z0-9_\-.:#\s>+~*()\[\]="\']*)$/', $selector ) ) {
						return '';
					}
				}
			}
			$depth++;
			if ( $depth > 2 ) {
				return '';
			}
		} elseif ( '}' === $char ) {
			$depth--;
			$buffer = '';
			if ( $depth < 0 ) {
				return '';
			}
			if ( 0 === $depth ) {
				$in_media = false;
			}
		} else {
			$buffer .= $char;
		}
	}
	return ( 0 === $depth ) ? $css : '';
}

/** Force every link onto the order site; relative links are resolved there, anything else is replaced. */
function sbs_pricing_cards_fix_links( $html ) {
	$origin = 'https://' . SBS_PRICING_CARDS_HOST;
	return preg_replace_callback(
		'/(<a\b[^>]*?\shref=)"([^"]*)"/i',
		static function ( $m ) use ( $origin ) {
			$href = html_entity_decode( $m[2], ENT_QUOTES, 'UTF-8' );
			if ( preg_match( '#^/(?!/)#', $href ) ) {
				$href = $origin . $href;
			}
			if ( ! sbs_pricing_cards_is_order_url( $href ) ) {
				$href = SBS_PRICING_CARDS_FALLBACK_URL;
			}
			return $m[1] . '"' . esc_url( $href ) . '"';
		},
		$html
	);
}

/** Raw fragment in, safe markup out ('' when it cannot be made safe). Prints the stylesheet once per request. */
function sbs_pricing_cards_render( $raw ) {
	static $style_printed = false;

	$css = '';
	if ( preg_match_all( '#<style\b[^>]*>(.*?)</style\s*>#is', $raw, $found ) ) {
		$css = sbs_pricing_cards_clean_css( implode( "\n", $found[1] ) );
	}
	$markup = preg_replace( '#<style\b[^>]*>.*?</style\s*>#is', '', $raw );
	// Drop the whole block (tags AND contents) of anything that can hold code or hidden text; wp_kses alone would leave the inner text behind.
	$markup = preg_replace( '#<(script|noscript|template|iframe|object|embed|textarea|title|head|xmp|plaintext)\b[^>]*>.*?</\1\s*>#is', '', (string) $markup );
	if ( null === $markup ) {
		return '';
	}
	$markup = wp_kses( $markup, sbs_pricing_cards_allowed_html(), array( 'https' ) );
	$markup = sbs_pricing_cards_fix_links( $markup );
	if ( null === $markup || false === strpos( $markup, 'pc-wrap' ) ) {
		return '';
	}

	$out    = '';
	$layout = sbs_pricing_cards_layout_css();
	if ( ! $style_printed && ( '' !== $css || '' !== $layout ) ) {
		$out           = '<style>' . $css . $layout . '</style>'; // $layout is our own constant CSS, printed after the validated remote CSS
		$style_printed = true;
	}
	return $out . $markup;
}

/**
 * Column count of the card grid. The order system's own stylesheet uses 4 columns on desktop, which is cramped,
 * so the plugin sets 2 (1 on phones) for every page. Change with:
 *   add_filter( 'sbs_pricing_cards_columns', function () { return 3; } );   // 1-4; any other value keeps the order system's layout
 */
function sbs_pricing_cards_layout_css() {
	$columns = (int) apply_filters( 'sbs_pricing_cards_columns', 2 );
	if ( $columns < 1 || $columns > 4 ) {
		return '';
	}
	$css = '.pc-wrap .pc-grid{grid-template-columns:repeat(' . $columns . ',minmax(0,1fr))}';
	if ( $columns > 2 ) {
		$css .= '@media (max-width:1024px){.pc-wrap .pc-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}';
	}
	return $css . '@media (max-width:600px){.pc-wrap .pc-grid{grid-template-columns:1fr}}';
}

function sbs_pricing_cards_fallback_html( $button_text ) {
	$label = esc_html( $button_text ? $button_text : 'See Pricing' );
	return '<p class="sbs-pricing-cards-fallback"><a href="' . esc_url( SBS_PRICING_CARDS_FALLBACK_URL ) . '" rel="noopener">' . $label . '</a></p>';
}

/* ------------------------------------------------------------------------------------------------
 * The shortcode
 * --------------------------------------------------------------------------------------------- */

function sbs_pricing_cards_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids'     => '',
			'popular' => '',
			'title'   => '',
			'button'  => 'Order Now',
			'link'    => '/configure',
			'cache'   => 30,
		),
		$atts,
		'sbs_pricing_cards'
	);

	// Allow-list: letters, digits, comma, pipe, plus, dash, whitespace; anything else is dropped.
	$ids = substr( preg_replace( '/[^A-Za-z0-9,|+\-\s]/', '', trim( (string) $atts['ids'] ) ), 0, 500 );
	if ( '' === trim( $ids ) ) {
		return '<!-- sbs_pricing_cards: "ids" attribute is required -->';
	}
	$popular = substr( preg_replace( '/[^A-Za-z0-9\-]/', '', (string) $atts['popular'] ), 0, 40 );
	$title   = substr( sanitize_text_field( (string) $atts['title'] ), 0, 120 );
	$button  = substr( sanitize_text_field( (string) $atts['button'] ), 0, 40 );
	if ( '' === $button ) {
		$button = 'Order Now';
	}
	$link = sbs_pricing_cards_clean_link( $atts['link'] );

	$can_manage    = current_user_can( 'manage_options' );
	$cache_minutes = (int) $atts['cache'];
	$cache_minutes = min( 1440, $cache_minutes );
	if ( $cache_minutes < 5 ) {
		// Never let page content turn every view into a call to the order system; only an administrator may disable caching.
		$cache_minutes = ( 0 === $cache_minutes && $can_manage ) ? 0 : 5;
	}

	$query = array( 'ids' => $ids, 'button' => $button, 'link' => $link );
	if ( '' !== $popular ) {
		$query['popular'] = $popular;
	}
	if ( '' !== $title ) {
		$query['title'] = $title;
	}
	$request_url = sbs_pricing_cards_request_url( $query );
	$cache_key   = 'sbs_pc_' . md5( $request_url );

	$force = $can_manage && isset( $_GET['sbs_pricing_refresh'] ); // phpcs:ignore WordPress.Security.NonceVerification -- only drops a cache entry
	if ( $force ) {
		delete_transient( $cache_key );
		delete_transient( $cache_key . '_fail' );
	}

	$raw = ( $cache_minutes > 0 ) ? get_transient( $cache_key ) : false;

	if ( false === $raw ) {
		$stale   = $force ? false : get_transient( $cache_key . '_stale' );
		$cron_on = ! ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ); // without WP-Cron a background refresh would never run
		if ( false !== $stale && $cache_minutes > 0 && $cron_on ) {
			// Expired but we still hold a good copy: show it now and refresh in the background.
			$args = array( $request_url, $cache_key, $cache_minutes );
			if ( ! wp_next_scheduled( 'sbs_pricing_cards_refresh', $args ) ) {
				wp_schedule_single_event( time(), 'sbs_pricing_cards_refresh', $args );
			}
			$raw = $stale;
		} elseif ( ! $force && get_transient( $cache_key . '_fail' ) ) {
			return sbs_pricing_cards_fallback_html( $button ); // the order system failed a moment ago; don't wait again
		} else {
			$raw = sbs_pricing_cards_fetch( $request_url );
			if ( false === $raw ) {
				set_transient( $cache_key . '_fail', 1, 60 );
				$stale = get_transient( $cache_key . '_stale' );
				if ( false === $stale ) {
					return sbs_pricing_cards_fallback_html( $button );
				}
				$raw = $stale;
			} else {
				sbs_pricing_cards_store( $cache_key, $raw, $cache_minutes );
			}
		}
	}

	$out = sbs_pricing_cards_render( (string) $raw );
	return ( '' === $out ) ? sbs_pricing_cards_fallback_html( $button ) : $out;
}
