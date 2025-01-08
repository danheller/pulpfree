<?php
/**
 * Block Name: Article Carousel
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 *
 * This is the template that displays the image list block.
 */

if ( ! function_exists( 'hex_is_dark' ) ) {
	/**
	 * Determine whether a hex color is dark.
	 *
	 * @param mixed $color Color.
	 * @return bool  True if a dark color.
	 */
	function hex_is_dark( $color ) {
		$hex = str_replace( '#', '', $color );

		$c_r = hexdec( substr( $hex, 0, 2 ) );
		$c_g = hexdec( substr( $hex, 2, 2 ) );
		$c_b = hexdec( substr( $hex, 4, 2 ) );

		$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

		return $brightness < 155;
	}
}

$group_id = 2672;
if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_article_carousel';
}

if (function_exists('acf_get_field_groups')) {
    $acf_fields = acf_get_fields( $group_id );
}
 
foreach( $acf_fields as $f ) {
	if( $f['name'] && trim( $f['name'] ) ) {
		$field_name = $f['name'];
		${ $field_name } = get_field( $field_name );
	}
}

$module_styles = array();
$shown = array(); // images shown, not to be repeated
$output = '';
// create id attribute for specific styling
$id = 'block-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

$block_class = '';
if( isset( $block['className'] ) && $block['className'] ) {
	$block_class = $block['className'] . ' ';
}


$output = '<div id="' . $id . '" class="' . $block_class . $align_class . ' article-carousel';

if( $title ) {
	$output .= ' has-title';
}

if( $background_color ) {
	if( hex_is_dark( $background_color ) ) {
		$output .= ' is-dark';
	}
	$output .= '" style="background-color:' . $background_color;
}

$output .= '">';

if( $title ) {
	$output .= '<header class="block-header">';
	$output .= '<h2>' . esc_html( $title ) . '</h2>';
	if( $description ) {
		$output .= '<p>' . $description . '</p>';
	}
	$output .= '</header>';
}

$output .= '<div class="block-content';
if( $carousel_title ) {
	$output .= ' has-carousel-title';
}
$output .= '">';

if( $carousel_title ) {
	$output .= '<div class="block-title">';
	$output .= '<h2>' . esc_html( $carousel_title ) . '</h2>';
	if( $carousel_description ) {
		$output .= '<p>' . esc_html( $carousel_description ) . '</p>';
	}
	$output .= '</div>';
}


if( 'manual' == $article_type ) {
	$items = new stdClass();
	$items->posts = array();
	if( $articles && count( $articles ) ) {
		// loop through the rows of data
		foreach ( $articles as $article ) { 
			$items->posts[] = $article;
		}
		$items->found_posts = count( $articles );
	} else {
		$output .= '<span class="hidden show-in-editor">Please choose one or more posts. </span>';
	}
} else {
	if( $number_of_posts ) {
		$args[ 'posts_per_page' ] = $number_of_posts;
	} else {
		$args[ 'posts_per_page' ] = 4;
	}
}

if( 'category' == $article_type  ) {
	if( $category ) {
		$argument = 'category__in';
		$args[$argument] = $category;
	} else {
		$output .= '<span class="hidden show-in-editor">Please choose a category. </span>';
	}
} else if( 'tag' == $article_type ) {
	if( $tag ) {
		$argument = 'tag__in';
		$args[$argument] = $tag;
	} else {
		$output .= '<span class="hidden show-in-editor">Please choose a tag. </span>';	
	}
}

if( $article_type && 'manual' != $article_type ) {
	$args[ 'post_type' ] = 'post';
	$args[ 'order' ] = 'DESC';
	$args[ 'orderby' ] = 'date';
	$args[ 'fields' ] = 'ids';
	
	$items = new WP_Query($args);
}

if( isset( $items ) && isset( $items->posts ) && count( $items->posts ) ) {

	if( $items && $items->found_posts && isset( $items->posts ) && is_array( $items->posts ) && count( $items->posts ) ) {
		$output .= '<div class="stories slider"><div class="wp-block-group__inner-container splide__track"><ul class="splide__list">';
		foreach( $items->posts as $item ) {
			$link = get_permalink( $item );
			if( get_post_meta( $item, 'external_url', true ) ) {
				$link = get_post_meta( $item, 'external_url', true );
			}
			$output .= '<li class="splide__slide"><div class="story"><a href="' . $link . '">';

			if ( has_post_thumbnail( $item ) ) {
				$image_id  = get_post_thumbnail_id( $item );
				$image_url = pulpfree_image_resize( $image_id, 800, 450 );
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				$output .= '<img src="' . $image_url . '" alt="' . $image_alt . '">';
			}
			$output .= '<div class="wrapper"><h3>' . esc_html( get_the_title( $item ) ) . '</h3>';	
			$output .= '<p class="excerpt">' . wp_trim_words( wp_strip_all_tags( get_the_excerpt( $item ) ), 40, '...' ) . '</p></div>';
			$output .= '</a><div class="controls"><button class="expand-collapse" aria-label="Show story description"></button></div></div></li>';
		}
		$output .= '</ul></div></div>';
	}

} else if( 'manual' != $article_type ) {

	$output .= '<span class="hidden show-in-editor">Please choose articles using the block settings in the sidebar.</span>';

}

$output .= '</div></div>';

echo $output;

