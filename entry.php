<?php
	$link = get_permalink( get_the_ID() );
	if( get_post_meta( get_the_ID(), 'external_url', true ) ) {
		$link = get_post_meta( get_the_ID(), 'external_url', true );
	}
	$categories = get_the_category( get_the_ID() );
	$eyebrow = '';
	if ( ! empty( $categories ) && isset( $categories[0] ) && isset( $categories[0]->name ) ) {
		$eyebrow = '<div class="eyebrow">' . esc_html( $categories[0]->name ) . '</div>';
	}

	// ACF fields that may have values
	$pagefields = array( 'featured_image_format', 'intro', 'hide_page_title' );
	foreach( $pagefields as $pf ) {
		${ $pf } = get_post_meta(get_the_ID(), $pf, true);
	}
	$postclass = '';

	$preview = false;
	if( ! is_singular() || ( isset( $GLOBALS['related'] ) && $GLOBALS['related'] ) ) {
		$preview = true;
		$postclass .= 'archive ';
	} else {
		if( has_post_thumbnail() && $featured_image_format && 'full' == $featured_image_format ) {
			$postclass .= 'has-full-image ';
		}
	}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( trim( $postclass ) ); ?>>
	<?php
		if ( ! $preview ) {
			$alt_image = get_post_meta( get_the_ID(), 'alt_featured_image', true );
			if ( ( has_post_thumbnail() || $alt_image ) && $featured_image_format && 'full' == $featured_image_format ) {
				$featured_img = get_post_thumbnail_id( $post->ID );
				if( $alt_image ) {
					$featured_img = $alt_image;
				}
				echo '<figure>' . pulpfree_wide_image( $featured_img ) . '</figure>';
				if(get_post( $featured_img )->post_excerpt) {
				?>
					<figcaption><p class="caption"><?php echo get_post( $featured_img )->post_excerpt; ?></p></figcaption>
				<?php
				}
			}
		?>
				<div class="share">
					<div class="title">Share</div>
					<ul>
						<li><a class="facebook" target="_blank" rel="nofollow noopener" href="https://www.addtoany.com/add_to/facebook?linkurl=<?php echo esc_url( get_permalink() ); ?>&amp;linkname=<?php echo esc_url( get_the_title() ); ?>%20-%20USC%20Giving" rel="nofollow noopener" aria-label="Facebook (link is external)"><span class="screen-reader-text">Share on Facebook</span></a></li>
						<li><a class="twitter" target="_blank" rel="nofollow noopener" href="https://www.addtoany.com/add_to/twitter?linkurl=<?php echo esc_url( get_permalink() ); ?>&amp;linkname=<?php echo esc_url( get_the_title() ); ?>%20-%20USC%20Giving" rel="nofollow noopener" aria-label="X (link is external)"><span class="screen-reader-text">Share on X</span></a></li>
						<li><a class="linkedin" target="_blank" rel="nofollow noopener" href="https://www.addtoany.com/add_to/linkedin?linkurl=<?php echo esc_url( get_permalink() ); ?>&amp;linkname=<?php echo esc_url( get_the_title() ); ?>%20-%20USC%20Giving" rel="nofollow noopener" aria-label="LinkedIn (link is external)"><span class="screen-reader-text">Share on LinkedIn</span></a></li>
						<li><a class="email" target="_blank" rel="nofollow noopener" href="mailto:?subject=<?php echo esc_url( get_the_title() ); ?>%20-%20USC%20Giving&amp;body=<?php echo esc_url( get_permalink() ); ?>" rel="nofollow noopener" aria-label="Email (link is external)"><span class="screen-reader-text">Email story</span></a></li>
					</ul>
				</div>
		<?php 
			echo '<header class="page-header">';
			echo $eyebrow;
			echo '<h1 class="entry-title" itemprop="headline">';
			the_title();
			echo '</h1>';
			echo '</header>';
		} else { // archive
			echo '<div class="entry-text"><header>';
			echo $eyebrow . '<h2 class="entry-title"><a href="' . $link . '" title="' . esc_attr( get_the_title() ) . '" rel="bookmark">';
			the_title();
			echo '</a></h2>';
			edit_post_link();
			echo '</header>';
		}
		get_template_part( 'entry', ( $preview || is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) );

		if ( $preview ) {
	?>
	</div>
	<?php
		if ( has_post_thumbnail() ) {
			$image_id  = get_post_thumbnail_id();
			$image_url = pulpfree_image_resize( $image_id, 800, 450 );
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		?>
		<div class="entry-image">
			<a href="<?php echo $link; ?>" title="<?php the_title_attribute(); ?>"><img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>"></a>
		</div>
		<?php
			}
		} else {
			get_template_part( 'related-articles' );
		}
	?>
</article>