<?php
	// redirect if post has an external URL
	$link = get_post_meta( get_the_ID(), 'external_url', true );
	if( $link ) {
		header( 'location: ' . $link );
	}
	// ACF fields that add options to the body tag's class
	$bodyclass = '';
	$bodyclassoptions = array( 'transparent' );
	foreach( $bodyclassoptions as $bco ) {
		if( get_post_meta( get_the_ID(), $bco, true ) ) {
			$bodyclass .= str_replace( '_', '-', $bco ) . ' ';
		}
	}
	// ACF fields that may have values
	$pagefields = array( 'top_shadow', 'bottom_shadow' );
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
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'entry' );
			edit_post_link( 'Edit “' . get_the_title() . '”' ); 
		}
	}
	get_footer();
