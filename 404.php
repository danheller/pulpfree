<?php 
	$bodyclass = 'archive search';
	get_header(); 
?>
	<article id="post-0" class="post not-found">
		<header class="page-header">
			<h1 class="entry-title" itemprop="name"><?php esc_html_e( 'Page Not Found', 'pulpfree' ); ?></h1>
		</header>

		<div class="entry-content" itemprop="mainContentOfPage">
			<p class="is-style-introduction">
				<?php esc_html_e( 'We’re sorry, we can’t find the page you requested.', 'pulpfree' ); ?>
			</p>

			<p>
				<?php _e( 'Please try using the site search to find what you need, or <a href="' . home_url() . '">go back home</a>.', 'pulpfree' ); ?>
			</p>
			<div class="search-again">
			<?php 
				ob_start();
				get_search_form();
				$search_form = ob_get_clean();
				echo str_replace( 'search-query', 'not-found-query', $search_form );
			?>
			</div>
		</div>
	</article>
<?php 
	get_footer();
