/**
 * SBS HTML sitemap: every published page and blog post on one page, rendered on the server.
 *
 * Use:      [sbs_sitemap]   in the page's HTML widget (sitemap.html) or an Elementor "Shortcode" widget.
 * Install:  Code Snippets plugin -> Add New -> PHP snippet -> "Run snippet everywhere" (paste this file as is),
 *           or at the end of a CHILD theme's functions.php (add an opening <?php tag first if needed).
 * Styles:   inside sitemap.html (nothing extra to paste).
 *
 * What it lists (always current, nothing to maintain by hand):
 *   - Pages: grouped like the site menu (see sbs_sitemap_page_groups()). A page that is not in any group
 *     lands in "More Pages", so a brand-new page is never missing from the sitemap.
 *   - Portfolio items: every published item of the Portfolio post type, in the "Our Work" card.
 *   - Blog posts: grouped by category (Yoast's primary category when set), newest first, each post once.
 * Left out on purpose: drafts, private and password-protected items, and anything set to noindex in Yoast.
 * The result is cached for 12 hours and cleared whenever a post, page or category is saved, trashed or deleted.
 *
 * Settings (filters, only if you need to change them):
 *   add_filter( 'sbs_sitemap_page_groups', function ( $groups ) { $groups['Our Work'][] = 'new-case-study'; return $groups; } );
 *   add_filter( 'sbs_sitemap_exclude_slugs', function ( $slugs ) { $slugs[] = 'thank-you'; return $slugs; } );
 */

add_shortcode( 'sbs_sitemap', 'sbs_sitemap_shortcode' );

foreach ( array( 'save_post', 'deleted_post', 'trashed_post', 'untrashed_post', 'edited_term', 'delete_term' ) as $sbs_sitemap_hook ) {
	add_action( $sbs_sitemap_hook, 'sbs_sitemap_flush_cache' );
}

function sbs_sitemap_flush_cache() {
	delete_transient( 'sbs_sitemap_html' );
}

/**
 * Page groups, in the order they print. Each group is a list of page slugs, printed in the order given.
 * The token "home" stands for the front page (its slug is not a real one).
 */
function sbs_sitemap_page_groups() {
	$groups = array(
		'Main Pages'         => array( 'home', 'all-services', 'blogs', 'contact-us', 'book-a-free-consultation' ),
		'Build'              => array( 'custom-web-development', 'woocommerce-stores', 'shopify-ecommerce-store', 'merchant-processing-add-on', 'wordpress-to-html-conversion', 'static-html-sites', 'custom-web-mobile-apps', 'amazon-listing-store-setup' ),
		'Maintain & Protect' => array( 'wordpress-maintenance-hosting-bundle', 'simple-site-hosting-bundle', 'website-care', 'email-setup-migration-services-gws-ms365' ),
		'Grow'               => array( 'seo-plans-site-audit', 'local-seo-google-business-profile', 'marketing-visibility-packages', 'google-meta-ads', 'walmart-ads-management' ),
		'Market & Brand'     => array( 'design', 'copywriting', 'social-media-setup-and-management', 'newsletter-services', 'go-high-level-service', 'crm-build-setup-management' ),
		'Our Work'           => array( 'our-portfolio' ), // the portfolio items themselves are added after these, see sbs_sitemap_pages_html()
		'About Us'           => array( 'who-we-are', 'awards-recognition', 'giving-back', 'what-our-clients-say', 'our-clients', 'tools-we-love', 'become-a-partner' ),
		'Locations'          => array( 'colorado' ),
		'Support & Updates'  => array( 'support', 'newsletter' ),
		'Legal'              => array( 'privacy-policy', 'terms-of-service', 'cookie-policy' ),
	);
	$groups = apply_filters( 'sbs_sitemap_page_groups', $groups );
	return is_array( $groups ) ? $groups : array();
}

/** Query args shared by pages and posts: published, no password, not noindex in Yoast. */
function sbs_sitemap_query_args( $post_type, $orderby, $order ) {
	return array(
		'post_type'           => $post_type,
		'post_status'         => 'publish',
		'has_password'        => false,
		'posts_per_page'      => -1,
		'orderby'             => $orderby,
		'order'               => $order,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'meta_query'          => array(
			'relation' => 'OR',
			array(
				'key'     => '_yoast_wpseo_meta-robots-noindex',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => '_yoast_wpseo_meta-robots-noindex',
				'value'   => '1',
				'compare' => '!=',
			),
		),
	);
}

function sbs_sitemap_link( $post, $label = '' ) {
	$label = '' !== $label ? $label : wp_strip_all_tags( get_the_title( $post ) );
	if ( '' === trim( $label ) ) {
		$label = $post->post_name;
	}
	return '<li><a href="' . esc_url( get_permalink( $post ) ) . '">' . esc_html( $label ) . '</a></li>';
}

function sbs_sitemap_group_html( $title, $items ) {
	if ( ! $items ) {
		return '';
	}
	return '<div class="sbs-sitemap-group"><h3 class="sbs-sitemap-group-title">' . esc_html( $title ) . '</h3><ul class="sbs-sitemap-list">' . implode( '', $items ) . '</ul></div>';
}

/** Portfolio items (the "Portfolio" post type), in the order the portfolio page shows them. */
function sbs_sitemap_portfolio_links() {
	$type = (string) apply_filters( 'sbs_portfolio_post_type', 'portfolio' );
	if ( ! post_type_exists( $type ) ) {
		return array();
	}
	$items = array();
	foreach ( get_posts( sbs_sitemap_query_args( $type, 'menu_order date', 'ASC' ) ) as $post ) {
		$items[] = sbs_sitemap_link( $post );
	}
	return $items;
}

/** Page cards: the groups above, then any page that is in none of them. */
function sbs_sitemap_pages_html() {
	$exclude = array_map( 'sanitize_title', (array) apply_filters( 'sbs_sitemap_exclude_slugs', array() ) );
	$front   = (int) get_option( 'page_on_front' );
	$by_slug = array();
	foreach ( get_posts( sbs_sitemap_query_args( 'page', 'title', 'ASC' ) ) as $page ) {
		$slug = $front && (int) $page->ID === $front ? 'home' : $page->post_name;
		if ( ! in_array( $page->post_name, $exclude, true ) ) {
			$by_slug[ $slug ] = $page;
		}
	}

	$html = '';
	foreach ( sbs_sitemap_page_groups() as $title => $slugs ) {
		$items = array();
		foreach ( (array) $slugs as $slug ) {
			if ( isset( $by_slug[ $slug ] ) ) {
				$items[] = sbs_sitemap_link( $by_slug[ $slug ], 'home' === $slug ? 'Home' : '' );
				unset( $by_slug[ $slug ] );
			}
		}
		if ( 'Our Work' === $title ) {
			$items = array_merge( $items, sbs_sitemap_portfolio_links() );
		}
		$html .= sbs_sitemap_group_html( $title, $items );
	}

	$items = array();
	foreach ( $by_slug as $page ) {
		$items[] = sbs_sitemap_link( $page );
	}
	return $html . sbs_sitemap_group_html( 'More Pages', $items );
}

/** The category a post is filed under in the sitemap: Yoast's primary one, else the first. */
function sbs_sitemap_post_category( $post_id ) {
	$cats = get_the_category( $post_id );
	if ( ! $cats ) {
		return null;
	}
	$primary = (int) get_post_meta( $post_id, '_yoast_wpseo_primary_category', true );
	foreach ( $cats as $cat ) {
		if ( (int) $cat->term_id === $primary ) {
			return $cat;
		}
	}
	return $cats[0];
}

/** Post cards: one per category (A to Z), each post listed once, newest first. */
function sbs_sitemap_posts_html() {
	$groups = array();
	$names  = array();
	foreach ( get_posts( sbs_sitemap_query_args( 'post', 'date', 'DESC' ) ) as $post ) {
		$cat = sbs_sitemap_post_category( $post->ID );
		$id  = $cat ? (int) $cat->term_id : 0;
		if ( ! isset( $groups[ $id ] ) ) {
			$groups[ $id ] = array();
			$names[ $id ]  = ( $cat && 'uncategorized' !== $cat->slug ) ? $cat->name : 'More Articles';
		}
		$groups[ $id ][] = sbs_sitemap_link( $post );
	}
	uasort(
		$names,
		function ( $a, $b ) {
			if ( 'More Articles' === $a || 'More Articles' === $b ) {
				return 'More Articles' === $a ? 1 : -1;
			}
			return strcasecmp( $a, $b );
		}
	);

	$html = '';
	foreach ( $names as $id => $name ) {
		$html .= sbs_sitemap_group_html( $name . ' (' . count( $groups[ $id ] ) . ')', $groups[ $id ] );
	}
	return $html;
}

function sbs_sitemap_build() {
	$pages = sbs_sitemap_pages_html();
	$posts = sbs_sitemap_posts_html();
	$html  = '<nav class="sbs-sitemap" aria-label="Sitemap">';
	if ( $pages ) {
		$html .= '<section class="sbs-sitemap-section"><h2 class="sbs-sitemap-heading">Pages</h2><div class="sbs-sitemap-groups">' . $pages . '</div></section>';
	}
	if ( $posts ) {
		$html .= '<section class="sbs-sitemap-section"><h2 class="sbs-sitemap-heading">Blog Posts</h2><div class="sbs-sitemap-groups sbs-sitemap-groups--wide">' . $posts . '</div></section>';
	}
	return $html . '</nav>';
}

function sbs_sitemap_shortcode() {
	$html = get_transient( 'sbs_sitemap_html' );
	if ( false === $html ) {
		$html = sbs_sitemap_build();
		set_transient( 'sbs_sitemap_html', $html, 12 * HOUR_IN_SECONDS );
	}
	return $html;
}
