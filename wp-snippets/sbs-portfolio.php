/**
 * SBS portfolio: the project cards and the previous / next project links, built from the "Portfolio" post type.
 *
 * Use:      [sbs_portfolio_grid]   on the Our Portfolio page (replaces the hand-written cards).
 *           [sbs_portfolio_nav]    at the bottom of each portfolio item (replaces the hand-written prev / next block).
 *           Both go in the page's HTML widget (our-portfolio.html and the portfolio-*.html files) or a Shortcode widget.
 * Install:  Code Snippets plugin -> Add New -> PHP snippet -> "Run snippet everywhere" (paste this file as is),
 *           or at the end of a CHILD theme's functions.php (add an opening <?php tag first if needed).
 * Styles:   already in our-portfolio.html (.portfolio-card ...) and in every portfolio-*.html (.project-nav-* ...).
 *
 * Which projects, and in what order: every PUBLISHED item of the post type, by its "Order" number (Page Attributes
 * box on the edit screen, lowest first), then oldest first. Items left at 0 therefore follow the order they were
 * published in. The first item's "previous" and the last item's "next" link to the portfolio page.
 * Each card shows the item's FEATURED IMAGE (a tall full-page screenshot: the card scrolls it on hover) and its
 * title. An item without a featured image still gets a card, just with an empty picture area.
 *
 * Caching: the links are written into the page HTML, so a cached page keeps its old neighbours when a project is
 * added, removed or re-ordered. The snippet therefore asks LiteSpeed Cache to purge the portfolio page and every
 * portfolio item whenever one is published, unpublished, trashed or edited (nothing happens without LiteSpeed).
 *
 * Settings (filters, only if you need to change them):
 *   add_filter( 'sbs_portfolio_post_type', fn() => 'portfolio' );                      // post type slug
 *   add_filter( 'sbs_portfolio_index_url', fn() => home_url( '/our-portfolio/' ) );    // "Browse All Projects" target
 */

add_shortcode( 'sbs_portfolio_grid', 'sbs_portfolio_grid_shortcode' );
add_shortcode( 'sbs_portfolio_nav', 'sbs_portfolio_nav_shortcode' );
add_action( 'init', 'sbs_portfolio_add_order_field', 20 );
add_action( 'transition_post_status', 'sbs_portfolio_purge_on_change', 10, 3 );

function sbs_portfolio_post_type() {
	return (string) apply_filters( 'sbs_portfolio_post_type', 'portfolio' );
}

function sbs_portfolio_index_url() {
	return (string) apply_filters( 'sbs_portfolio_index_url', home_url( '/our-portfolio/' ) );
}

/** Shows the "Order" box on the edit screen so the sequence can be set by hand. */
function sbs_portfolio_add_order_field() {
	add_post_type_support( sbs_portfolio_post_type(), 'page-attributes' );
}

/** Published projects in display order. Looked up once per request. */
function sbs_portfolio_items() {
	static $items = null;
	if ( null === $items ) {
		$items = get_posts(
			array(
				'post_type'           => sbs_portfolio_post_type(),
				'post_status'         => 'publish',
				'has_password'        => false,
				'posts_per_page'      => -1,
				'orderby'             => array(
					'menu_order' => 'ASC',
					'date'       => 'ASC',
				),
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
	}
	return $items;
}

function sbs_portfolio_title( $post ) {
	$title = trim( wp_strip_all_tags( get_the_title( $post ) ) );
	return '' !== $title ? $title : $post->post_name;
}

function sbs_portfolio_svg( $paths, $stroke_width, $size = '' ) {
	$dims = '' === $size ? '' : ' width="' . $size . '" height="' . $size . '"';
	return '<svg' . $dims . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="' . $stroke_width . '" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths . '</svg>';
}

function sbs_portfolio_icon( $name ) {
	switch ( $name ) {
		case 'prev':
			return sbs_portfolio_svg( '<path d="M19 12H5"/><path d="m12 19-7-7 7-7"/>', '2.4' );
		case 'next':
			return sbs_portfolio_svg( '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>', '2.4' );
		case 'details':
			return sbs_portfolio_svg( '<path d="M5 12h14M13 5l7 7-7 7"/>', '2', '15' );
		default: // grid of squares = "all projects"
			return sbs_portfolio_svg( '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>', '2' );
	}
}

/** The featured image as an <img>, or '' when the project has none. */
function sbs_portfolio_image( $post, $size, $attrs ) {
	$thumb_id = (int) get_post_thumbnail_id( $post );
	return $thumb_id ? (string) wp_get_attachment_image( $thumb_id, $size, false, $attrs ) : '';
}

/* ---- cards ------------------------------------------------------------------------------------------------- */

function sbs_portfolio_card( $post, $index ) {
	$title = sbs_portfolio_title( $post );
	$alt   = '';
	$thumb = (int) get_post_thumbnail_id( $post );
	if ( $thumb ) {
		$alt = trim( (string) get_post_meta( $thumb, '_wp_attachment_image_alt', true ) );
	}
	$img = sbs_portfolio_image(
		$post,
		'large',
		array(
			'alt'     => '' !== $alt ? $alt : $title . ' website design',
			'loading' => $index < 3 ? 'eager' : 'lazy',
			'sizes'   => '(max-width: 600px) 100vw, (max-width: 1024px) 50vw, 400px',
		)
	);
	return '<a href="' . esc_url( get_permalink( $post ) ) . '" class="portfolio-card">'
		. '<div class="portfolio-img-wrap">' . $img . '</div>'
		. '<div class="portfolio-info"><span class="portfolio-client-title">' . esc_html( $title ) . '</span>'
		. '<span class="portfolio-live-link">Details' . sbs_portfolio_icon( 'details' ) . '</span></div>'
		. '</a>';
}

function sbs_portfolio_grid_shortcode() {
	$cards = '';
	foreach ( sbs_portfolio_items() as $index => $post ) {
		$cards .= sbs_portfolio_card( $post, $index );
	}
	return '' === $cards ? '' : '<div class="portfolio-grid">' . $cards . '</div>';
}

/* ---- previous / next ----------------------------------------------------------------------------------------- */

/** A "Browse All Projects" card, used where there is no project before the first or after the last one. */
function sbs_portfolio_nav_all( $direction ) {
	$is_prev = 'prev' === $direction;
	$arrow   = '<span class="project-nav-arrow" aria-hidden="true">' . sbs_portfolio_icon( 'all' ) . '</span>';
	$text    = '<span class="project-nav-text"><span class="project-nav-label">' . ( $is_prev ? 'Start of the portfolio' : 'End of the portfolio' )
		. '</span><span class="project-nav-name">Browse All Projects</span></span>';
	return '<a href="' . esc_url( sbs_portfolio_index_url() ) . '" class="project-nav-card project-nav-' . $direction . ' project-nav-all">'
		. ( $is_prev ? $arrow . $text : $text . $arrow ) . '</a>';
}

/** A previous / next card for a project. */
function sbs_portfolio_nav_card( $direction, $post ) {
	$is_prev = 'prev' === $direction;
	$arrow   = '<span class="project-nav-arrow" aria-hidden="true">' . sbs_portfolio_icon( $direction ) . '</span>';
	$img     = sbs_portfolio_image( $post, 'medium', array( 'alt' => '', 'loading' => 'lazy', 'sizes' => '120px' ) );
	$thumb   = '' === $img ? '' : '<span class="project-nav-thumb">' . $img . '</span>';
	$text    = '<span class="project-nav-text"><span class="project-nav-label">' . ( $is_prev ? 'Previous Project' : 'Next Project' )
		. '</span><span class="project-nav-name">' . esc_html( sbs_portfolio_title( $post ) ) . '</span></span>';
	return '<a href="' . esc_url( get_permalink( $post ) ) . '" class="project-nav-card project-nav-' . $direction . '" rel="' . $direction . '">'
		. ( $is_prev ? $arrow . $thumb . $text : $text . $thumb . $arrow ) . '</a>';
}

function sbs_portfolio_nav_shortcode() {
	$current = (int) get_queried_object_id();
	if ( ! $current ) {
		$current = (int) get_the_ID();
	}
	if ( ! $current || get_post_type( $current ) !== sbs_portfolio_post_type() ) {
		return '';
	}

	$items = sbs_portfolio_items();
	$pos   = count( $items ); // a draft or preview that is not published yet counts as "after the last project"
	foreach ( $items as $index => $post ) {
		if ( (int) $post->ID === $current ) {
			$pos = $index;
			break;
		}
	}

	$prev = isset( $items[ $pos - 1 ] ) ? sbs_portfolio_nav_card( 'prev', $items[ $pos - 1 ] ) : sbs_portfolio_nav_all( 'prev' );
	$next = isset( $items[ $pos + 1 ] ) ? sbs_portfolio_nav_card( 'next', $items[ $pos + 1 ] ) : sbs_portfolio_nav_all( 'next' );
	return '<nav class="project-nav-grid" aria-label="Portfolio navigation">' . $prev . $next . '</nav>';
}

/* ---- keep cached pages in step ------------------------------------------------------------------------------- */

function sbs_portfolio_purge_on_change( $new_status, $old_status, $post ) {
	if ( sbs_portfolio_post_type() !== $post->post_type || ( 'publish' !== $new_status && 'publish' !== $old_status ) ) {
		return;
	}
	do_action( 'litespeed_purge_url', sbs_portfolio_index_url() );
	do_action( 'litespeed_purge_post', $post->ID );
	foreach ( sbs_portfolio_items() as $item ) {
		do_action( 'litespeed_purge_post', $item->ID );
	}
}
