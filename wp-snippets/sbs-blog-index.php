/**
 * SBS blog index: category buttons + post grid + numbered pagination, rendered on the server.
 *
 * Use:      [sbs_blog_index]   in an Elementor "Shortcode" widget on the /blogs/ page (under the banner).
 * Install:  Code Snippets plugin -> Add New -> PHP snippet -> "Run snippet everywhere" (paste this file as is),
 *           or at the end of a CHILD theme's functions.php (add an opening <?php tag first if needed).
 * Styles:   sbs-blog-index.css (paste into the page's Custom CSS: Elementor > Page Settings > Advanced).
 * Replaces: the JavaScript grid / infinite scroll in blogs.html.
 *
 * URLs it produces (all real links, no JavaScript needed):
 *   /blogs/                          first 12 posts
 *   /blogs/page/2/ ... /page/20/     next pages
 *   /blogs/?topic=web-design         one category (its own pages: /blogs/page/2/?topic=web-design)
 * We use "topic", not "cat": WordPress reserves ?cat= for category IDs and may 404 a page that receives it.
 *
 * SEO helpers at the bottom (they only do something when Yoast SEO is active):
 *   - paged URLs get a canonical that points to themselves,
 *   - category-filtered views are noindex,follow (they are subsets of the unfiltered pages),
 *   - a page number beyond the last page returns a real 404.
 *
 * Settings (filters, only if you need to change them):
 *   add_filter( 'sbs_blog_index_per_page', fn() => 12 );   // posts per page
 *   add_filter( 'sbs_blog_index_slug', fn() => 'blogs' );  // slug of the page that holds the shortcode
 */

add_shortcode( 'sbs_blog_index', 'sbs_blog_index_shortcode' );
add_action( 'template_redirect', 'sbs_blog_index_guard_pages' );
add_filter( 'wpseo_canonical', 'sbs_blog_index_canonical' );
add_filter( 'wpseo_robots', 'sbs_blog_index_robots' );

function sbs_blog_index_per_page() {
	return max( 1, (int) apply_filters( 'sbs_blog_index_per_page', 12 ) );
}

function sbs_blog_index_slug() {
	return (string) apply_filters( 'sbs_blog_index_slug', 'blogs' );
}

/** Current page number (WordPress puts /page/N/ of a Page in "paged"). */
function sbs_blog_index_current_page() {
	$paged = (int) get_query_var( 'paged' );
	if ( $paged < 1 ) {
		$paged = (int) get_query_var( 'page' );
	}
	return max( 1, $paged );
}

/** Category slug from ?topic=, or '' when missing or unknown. */
function sbs_blog_index_topic() {
	$raw = isset( $_GET['topic'] ) ? wp_unslash( $_GET['topic'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput -- read-only filter, no state change
	if ( ! is_string( $raw ) || '' === $raw ) {
		return ''; // missing, empty or an array (?topic[]=x)
	}
	$slug = sanitize_title( $raw );
	return ( $slug && term_exists( $slug, 'category' ) ) ? $slug : '';
}

function sbs_blog_index_base_url() {
	$id  = get_queried_object_id();
	$url = $id ? get_permalink( $id ) : home_url( '/' . sbs_blog_index_slug() . '/' );
	return trailingslashit( $url );
}

function sbs_blog_index_query_args( $topic, $paged ) {
	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'has_password'        => false,
		'posts_per_page'      => sbs_blog_index_per_page(),
		'paged'               => $paged,
		'ignore_sticky_posts' => true,
	);
	if ( $topic ) {
		$args['category_name'] = $topic;
	}
	return $args;
}

function sbs_blog_index_fallback_icon() {
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>';
}

function sbs_blog_index_shortcode() {
	$topic = sbs_blog_index_topic();
	$paged = sbs_blog_index_current_page();
	$base  = sbs_blog_index_base_url();
	$frag  = '#sbs-blog-index'; // keeps the reader at the grid after clicking a page or category

	$query = new WP_Query( sbs_blog_index_query_args( $topic, $paged ) );
	$total = (int) $query->found_posts;
	$pages = (int) $query->max_num_pages;
	$terms = get_terms(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
			'orderby'    => 'count',
			'order'      => 'DESC',
		)
	);

	ob_start();
	?>
	<div class="sbs-blog-index" id="sbs-blog-index">

		<div class="blog-toolbar">
			<nav class="blog-cat-pills" aria-label="Filter by category">
				<a class="blog-cat-pill<?php echo $topic ? '' : ' is-active'; ?>" href="<?php echo esc_url( $base . $frag ); ?>"<?php echo $topic ? '' : ' aria-current="page"'; ?>>All Posts</a>
				<?php
				if ( ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						if ( 'uncategorized' === $term->slug ) {
							continue;
						}
						$active = ( $topic === $term->slug );
						?>
						<a class="blog-cat-pill<?php echo $active ? ' is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'topic', $term->slug, $base ) . $frag ); ?>"<?php echo $active ? ' aria-current="page"' : ''; ?>>
							<?php echo esc_html( $term->name ); ?> <span class="blog-cat-pill-count"><?php echo (int) $term->count; ?></span>
						</a>
						<?php
					}
				}
				?>
			</nav>
		</div>

		<?php if ( $query->have_posts() ) : ?>
			<?php
			$first = ( $paged - 1 ) * sbs_blog_index_per_page() + 1;
			$last  = $first + $query->post_count - 1;
			?>
			<p class="blog-results-label">
				<?php
				printf(
					/* translators: 1: first post number, 2: last post number, 3: total posts */
					esc_html( _n( 'Showing %1$d–%2$d of %3$d article', 'Showing %1$d–%2$d of %3$d articles', $total, 'sbs' ) ),
					(int) $first,
					(int) $last,
					(int) $total
				);
				?>
			</p>

			<div class="blog-grid">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$cats  = get_the_category();
					$badge = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : 'Blog';
					$image = get_the_post_thumbnail(
						get_the_ID(),
						'medium_large',
						array(
							'alt'      => '',
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					?>
					<article class="blog-card">
						<a class="blog-card-link" href="<?php echo esc_url( get_permalink() ); ?>">
							<div class="blog-card-image-wrap">
								<?php
								if ( $image ) {
									echo $image; // phpcs:ignore WordPress.Security.EscapeOutput -- core-generated <img>
								} else {
									echo '<div class="blog-card-image-fallback">' . sbs_blog_index_fallback_icon() . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG
								}
								?>
								<span class="blog-card-cat-badge"><?php echo esc_html( $badge ); ?></span>
							</div>
							<div class="blog-card-body">
								<div class="blog-card-date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></div>
								<h2 class="blog-card-title"><?php echo esc_html( get_the_title() ); ?></h2>
								<div class="blog-card-excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 30, '…' ) ); ?></div>
								<span class="blog-card-readmore">Read Article <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
							</div>
						</a>
					</article>
				<?php endwhile; ?>
			</div>

			<?php
			if ( $pages > 1 ) {
				$links = paginate_links(
					array(
						'base'         => $base . '%_%',
						'format'       => 'page/%#%/',
						'current'      => $paged,
						'total'        => $pages,
						'mid_size'     => 1,
						'end_size'     => 1,
						'prev_text'    => '<span aria-hidden="true">&larr;</span> Previous',
						'next_text'    => 'Next <span aria-hidden="true">&rarr;</span>',
						'type'         => 'array',
						'add_args'     => $topic ? array( 'topic' => $topic ) : false,
						'add_fragment' => $frag,
					)
				);
				if ( $links ) {
					echo '<nav class="blog-pagination" aria-label="Blog pagination"><ul class="blog-pagination-list">';
					foreach ( $links as $link ) {
						echo '<li>' . $link . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput -- core-generated, already escaped
					}
					echo '</ul></nav>';
				}
			}
			?>

		<?php else : ?>
			<div class="blog-empty-state">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				<h3>No articles found</h3>
				<p>Try a different category, or check back soon for new posts.</p>
			</div>
		<?php endif; ?>

	</div>
	<?php
	wp_reset_postdata();
	return ob_get_clean();
}

/** A page number past the last page is a real 404 (otherwise /blogs/page/99/ would be an empty, indexable page). */
function sbs_blog_index_guard_pages() {
	if ( ! is_page( sbs_blog_index_slug() ) ) {
		return;
	}
	$paged = sbs_blog_index_current_page();
	if ( $paged < 2 ) {
		return;
	}
	$probe = new WP_Query(
		array_merge(
			sbs_blog_index_query_args( sbs_blog_index_topic(), 1 ),
			array( 'fields' => 'ids' )
		)
	);
	if ( $paged > max( 1, (int) $probe->max_num_pages ) ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
	}
}

/** Yoast: every paginated page is its own canonical. */
function sbs_blog_index_canonical( $canonical ) {
	if ( ! is_page( sbs_blog_index_slug() ) ) {
		return $canonical;
	}
	$paged = sbs_blog_index_current_page();
	$base  = sbs_blog_index_base_url();
	return $paged > 1 ? $base . 'page/' . $paged . '/' : $base;
}

/** Yoast: category-filtered views are not indexed (their posts are already on the unfiltered pages). */
function sbs_blog_index_robots( $robots ) {
	if ( is_page( sbs_blog_index_slug() ) && sbs_blog_index_topic() ) {
		return 'noindex, follow';
	}
	return $robots;
}
