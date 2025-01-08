<?php
	get_header();
?>
	<header class="page-header">
		<h1 class="entry-title" itemprop="name"><?php single_term_title(); ?></h1>
		<div class="archive-meta" itemprop="description"><?php if ( '' != get_the_archive_description() ) { echo esc_html( get_the_archive_description() ); } ?></div>
	</header>
<?php 
	get_template_part( 'term', 'jump' );
	echo '<div class="entry-content" itemprop="mainContentOfPage">';
	if ( have_posts() ) {
		while ( have_posts() ) {
			 the_post();
			 get_template_part( 'entry' );
		}
	}
	get_template_part( 'nav', 'below' );
	echo '</div>';
	get_footer();
