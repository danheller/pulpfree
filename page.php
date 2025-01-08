<?php
	// ACF fields that add options to the body tag's class
	$bodyclass = '';
	$bodyclassoptions = array( 'transparent' );
	foreach( $bodyclassoptions as $bco ) {
		if( get_post_meta( get_the_ID(), $bco, true ) ) {
			$bodyclass .= str_replace( '_', '-', $bco ) . ' ';
		}
	}
	// ACF fields that may have values
	$pagefields = array( 'page_menu', 'featured_image_format', 'intro', 'hide_page_title', 'top_shadow', 'bottom_shadow' );
	foreach( $pagefields as $pf ) {
		${ $pf } = get_post_meta(get_the_ID(), $pf, true);
	}
	if( isset( $top_shadow ) && 'default' != $top_shadow ) {
		$bodyclass .= 'top-shadow-' . $top_shadow . ' ';
	}

	if( isset( $bottom_shadow ) && 'default' != $bottom_shadow ) {
		$bodyclass .= 'bottom-shadow-' . $bottom_shadow . ' ';
	}
	get_header();

	if( current_user_can('edit_pages') ) {
		get_template_part( 'customizer-widget' );
	}

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post(); 
			$postclass = '';
			// ACF options that are turned on/off
			$postclassoptions = array( 'show_page_menu' );
			foreach( $postclassoptions as $pco ) {
				if( get_post_meta( get_the_ID(), $pco, true ) ) {
					$postclass .= str_replace( '_', '-', $pco ) . ' ';
				}
			}
		?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $postclass ); ?>>
		<?php
			// cover photo option (TO DO: add select field/s to choose featured photo layout)
			if ( has_post_thumbnail() && 'full' == $featured_image_format ) {
				echo '<header class="page-header full-image">';
				echo '<div class="wp-block-cover short" style="min-height:430px;aspect-ratio:unset;"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>';
				echo pulpfree_wide_image( get_post_thumbnail_id( get_the_ID() ), array( 'itemprop' => 'image', 'fetchpriority' => 'high', 'decoding' => 'async', 'class' => 'wp-block-cover__image-background', 'data-object-fit' => 'cover' ) );
				echo '<div class="wp-block-cover__inner-container is-layout-constrained wp-block-cover-is-layout-constrained"><h1 class="wp-block-heading">' . get_the_title() . '</h1>';
				if( $intro ) {
					echo '<h2 class="subhead">' . $intro . '</h2>';
				}
				echo '</div></div></header>';
			} else if( ! isset( $hide_page_title ) || ! $hide_page_title ) {
			?>
					<header class="page-header">
					<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
					</header>
			<?php			
			}

			// page menu
			if ( false !== strpos( $postclass, 'show-page-menu' ) && $page_menu ) {
				echo '<aside class="sidebar"><div class="page-menu"><h2 class="screen-reader-text">On this page</h2><button class="page-menu-toggle" aria-controls="sections" has-popup="true" aria-label="Jump to a section" aria-hidden="true">Jump to a section</button><nav id="sections">' . $page_menu . '</nav></div></aside>';
			}

		?>

		<div class="entry-content" itemprop="mainContentOfPage">
		<?php
			the_content(); ?>
			<div class="entry-links"><?php wp_link_pages(); ?></div>
			<?php edit_post_link( 'Edit “' . get_the_title() . '”' ); ?>
		</div>
	</article>
<?php 
	//	if ( comments_open() && !post_password_required() ) { comments_template( '', true ); }
		}
	}
	get_footer();
