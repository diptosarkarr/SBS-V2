/**
 * SBS blog sidebar: search + Recent Posts + CTA box, rendered on the server.
 *
 * Use:      [sbs_blog_sidebar]   (optional: [sbs_blog_sidebar count="5"])
 *           in an Elementor "Shortcode" widget inside the Single Post template.
 * Install:  Code Snippets plugin -> Add New -> PHP snippet -> "Run snippet everywhere" (paste this file as is),
 *           or paste it at the end of a CHILD theme's functions.php (add an opening <?php tag first if the file
 *           doesn't already start with one). Never edit the parent Hello Elementor theme: updates erase it.
 * Styles:   sbs-blog-sidebar.css (paste into the Single Post template's Custom CSS).
 *
 * Why PHP: the recent-post links must be in the HTML the server sends (crawlers without JavaScript see them).
 * The live-search dropdown is only an enhancement; without JavaScript the form submits to the normal WordPress
 * search, limited to blog posts.
 */

add_shortcode( 'sbs_blog_sidebar', 'sbs_blog_sidebar_shortcode' );

/** Book icon shown when a post has no featured image. */
function sbs_blog_sidebar_fallback_icon() {
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>';
}

function sbs_blog_sidebar_shortcode( $atts ) {
	$atts  = shortcode_atts( array( 'count' => 5 ), $atts, 'sbs_blog_sidebar' );
	$count = max( 1, min( 10, (int) $atts['count'] ) );

	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'has_password'        => false,
		'posts_per_page'      => $count,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);
	if ( is_singular( 'post' ) ) {
		$args['post__not_in'] = array( get_queried_object_id() ); // don't list the post being read
	}
	$recent = new WP_Query( $args );

	// Print the live-search script once, in the footer, only on pages that use this shortcode.
	add_action( 'wp_footer', 'sbs_blog_sidebar_live_search_script', 99 );

	ob_start();
	?>
	<div class="sbs-post-sidebar">

		<div class="sidebar-widget">
			<form class="sidebar-search-form" id="sidebar-search-form" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" autocomplete="off">
				<input type="hidden" name="post_type" value="post">
				<input type="search" name="s" class="sidebar-search-input" id="sidebar-search-input" placeholder="Search here" aria-label="Search the blog" required>
				<button type="submit" class="sidebar-search-btn" aria-label="Search">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				</button>
				<div class="sidebar-search-results" id="sidebar-search-results"></div>
			</form>
		</div>

		<?php if ( $recent->have_posts() ) : ?>
		<div class="sidebar-widget">
			<div class="sidebar-widget-title">Recent Posts</div>
			<ul class="sidebar-recent-list">
				<?php
				while ( $recent->have_posts() ) :
					$recent->the_post();
					$thumb = get_the_post_thumbnail(
						get_the_ID(),
						'thumbnail',
						array(
							'class'   => 'sidebar-recent-thumb',
							'alt'     => '',
							'loading' => 'lazy',
						)
					);
					?>
					<li class="sidebar-recent-item">
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<?php
							if ( $thumb ) {
								echo $thumb; // phpcs:ignore WordPress.Security.EscapeOutput -- core-generated <img>
							} else {
								echo '<span class="sidebar-recent-thumb-fallback">' . sbs_blog_sidebar_fallback_icon() . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG
							}
							?>
							<span class="sidebar-recent-title"><?php echo esc_html( get_the_title() ); ?></span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php endif; ?>

		<div class="sidebar-cta-box">
			<div class="sidebar-cta-title">Let's Drive More Traffic, Engage Customers, and Grow Your Business!</div>
			<div class="sidebar-cta-buttons">
				<a href="tel:+13853555351" class="sidebar-btn sidebar-btn-light">Call Us Today: (385) 355-5351</a>
				<a href="/book-a-free-consultation/" class="sidebar-btn sidebar-btn-outline">Book a Free Consultation</a>
			</div>
		</div>

	</div>
	<?php
	wp_reset_postdata();
	return ob_get_clean();
}

/** Live search dropdown (enhancement only). */
function sbs_blog_sidebar_live_search_script() {
	?>
	<script>
	(function () {
		var form = document.getElementById('sidebar-search-form');
		if (!form) { return; }
		var input = document.getElementById('sidebar-search-input');
		var box = document.getElementById('sidebar-search-results');
		var api = <?php echo wp_json_encode( esc_url_raw( rest_url( 'wp/v2/posts' ) ) ); ?>;
		var icon = <?php echo wp_json_encode( sbs_blog_sidebar_fallback_icon() ); ?>;
		var timer, token = 0, results = [];

		function toText(html) {
			return new DOMParser().parseFromString(html || '', 'text/html').documentElement.textContent.trim();
		}
		function close() {
			box.className = 'sidebar-search-results';
			box.textContent = '';
			results = [];
		}
		function status(msg) {
			box.textContent = '';
			var d = document.createElement('div');
			d.className = 'sidebar-search-status';
			d.textContent = msg;
			box.appendChild(d);
			box.classList.add('is-open');
		}
		function thumb(post) {
			var m = post._embedded && post._embedded['wp:featuredmedia'] && post._embedded['wp:featuredmedia'][0];
			if (!m || m.code) { return ''; }
			var s = m.media_details && m.media_details.sizes;
			return (s && s.thumbnail && s.thumbnail.source_url) || m.source_url || '';
		}
		function render(posts) {
			if (!posts.length) { status('No articles found.'); return; }
			box.textContent = '';
			posts.forEach(function (p) {
				var item = document.createElement('div');
				item.className = 'sidebar-search-result-item';
				var a = document.createElement('a');
				a.href = p.link;
				var src = thumb(p);
				if (src) {
					var img = document.createElement('img');
					img.className = 'sidebar-search-result-thumb';
					img.src = src; img.alt = ''; img.loading = 'lazy';
					a.appendChild(img);
				} else {
					var f = document.createElement('span');
					f.className = 'sidebar-search-result-thumb-fallback';
					f.innerHTML = icon; // static SVG from PHP
					a.appendChild(f);
				}
				var t = document.createElement('span');
				t.className = 'sidebar-search-result-title';
				t.textContent = toText(p.title && p.title.rendered);
				a.appendChild(t);
				item.appendChild(a);
				box.appendChild(item);
			});
			box.classList.add('is-open');
		}
		function run(q) {
			var mine = ++token;
			status('Searching...');
			var sep = api.indexOf('?') > -1 ? '&' : '?';
			fetch(api + sep + 'search=' + encodeURIComponent(q) + '&per_page=6&_embed=wp:featuredmedia')
				.then(function (r) { return r.json(); })
				.then(function (posts) { if (mine === token) { results = posts; render(posts); } })
				.catch(function () { if (mine === token) { status("Couldn't load results."); } });
		}

		input.addEventListener('input', function () {
			clearTimeout(timer);
			var q = input.value.trim();
			if (q.length < 2) { close(); return; }
			timer = setTimeout(function () { run(q); }, 350);
		});
		input.addEventListener('focus', function () {
			if (input.value.trim().length >= 2 && results.length) { box.classList.add('is-open'); }
		});
		document.addEventListener('click', function (e) { if (!form.contains(e.target)) { close(); } });
		form.addEventListener('submit', function (e) {
			if (results.length) { e.preventDefault(); window.location.href = results[0].link; }
		});
	})();
	</script>
	<?php
}
