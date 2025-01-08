<?php 
	get_header(); 
?>
<article <?php post_class( $postclass ); ?>>
	<header class="page-header">
		<h1 class="entry-title" itemprop="name"><?php the_archive_title(); ?></h1>
		<div class="archive-meta" itemprop="description">
			<?php
			if ( '' != get_the_archive_description() ) {
				echo esc_html( get_the_archive_description() );
			}
			?>
		</div>
	</header>
	<div class="entry-content" itemprop="mainContentOfPage">
<?php 
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'entry' );
		}
	}

	get_template_part( 'nav', 'below' );
?>
	</div>
</article>
<?php
	get_footer();
