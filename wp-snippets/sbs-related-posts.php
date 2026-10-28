/**
 * SBS "You Might Also Like": related posts for the Single Post template, rendered on the server.
 *
 * Use:      [sbs_related_posts]
 *           optional: [sbs_related_posts count="3" title="You Might Also Like"]   (title="" hides the heading)
 *           in an Elementor "Shortcode" widget inside the Single Post template, below the article.
 * Install:  Code Snippets plugin -> Add New -> PHP snippet -> "Run snippet everywhere" (paste this file as is),
 *           or at the end of a CHILD theme's functions.php (add an opening <?php tag first if needed).
 * Styles:   sbs-related-posts.css (paste into the Single Post template's Custom CSS, next to the sidebar CSS).
 *
 * Which posts: the newest posts from the same category as the post being read (Yoast's primary category when set),
 * never the post itself. If that category has fewer posts than "count", the rest are topped up with the newest
 * posts, so the section is never half empty. The links are in the HTML the server sends, so crawlers see them.
 * Prints nothing when there is nothing to show.
 */

add_shortcode( 'sbs_related_posts', 'sbs_related_posts_shortcode' );

/** Category used to find related posts: Yoast primary category, else the first category. */
function sbs_related_posts_category_id( $post_id ) {
	if ( ! $post_id ) {
		return 0;
	}
	$primary = (int) get_post_meta( $post_id, '_yoast_wpseo_primary_category', true );
	if ( $primary ) {
		return $primary;
	}
	$cats = get_the_category( $post_id );
	return ( $cats && ! is_wp_error( $cats ) ) ? (int) $cats[0]->term_id : 0;
}

function sbs_related_posts_shortcode( $atts ) {
	$atts  = shortcode_atts(
		array(
			'count' => 3,
			'title' => 'You Might Also Like',
		),
		$atts,
		'sbs_related_posts'
	);
	$count   = max( 1, min( 6, (int) $atts['count'] ) );
	$current = is_singular( 'post' ) ? get_queried_object_id() : 0;
	$exclude = $current ? array( $current ) : array();

	$base = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'has_password'        => false,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'fields'              => 'ids',
	);

	// 1. Same category, newest first.
	$ids    = array();
	$cat_id = sbs_related_posts_category_id( $current );
	if ( $cat_id ) {
		$ids = get_posts(
			array_merge(
				$base,
				array(
					'posts_per_page' => $count,
					'category__in'   => array( $cat_id ),
					'post__not_in'   => $exclude,
				)
			)
		);
	}

	// 2. Top up with the newest posts.
	if ( count( $ids ) < $count ) {
		$more = get_posts(
			array_merge(
				$base,
				array(
					'posts_per_page' => $count - count( $ids ),
					'post__not_in'   => array_merge( $exclude, $ids ),
				)
			)
		);
		$ids  = array_merge( $ids, $more );
	}

	if ( ! $ids ) {
		return '';
	}

	$query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post__in'            => $ids,
			'orderby'             => 'post__in',
			'posts_per_page'      => count( $ids ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);

	ob_start();
	?>
	<div class="sbs-related-posts">
		<?php if ( '' !== trim( $atts['title'] ) ) : ?>
			<h2 class="related-posts-title"><?php echo esc_html( $atts['title'] ); ?></h2>
		<?php endif; ?>
		<div class="related-posts-grid">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				$cats  = get_the_category();
				$badge = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
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
				<a class="related-post-card" href="<?php echo esc_url( get_permalink() ); ?>">
					<div class="related-post-image-wrap">
						<?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput -- core-generated <img> ?>
						<?php if ( $badge ) : ?>
							<span class="related-post-cat-badge"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
					</div>
					<div class="related-post-body">
						<div class="related-post-date"><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></div>
						<h3 class="related-post-title"><?php echo esc_html( get_the_title() ); ?></h3>
					</div>
				</a>
			<?php endwhile; ?>
		</div>
	</div>
	<?php
	wp_reset_postdata();
	return ob_get_clean();
}
