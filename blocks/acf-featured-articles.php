<?php
/**
 * Block Name: Featured Articles
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

$group_id = 2504;
if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_featured_articles';
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

// create id attribute for specific styling
$id = 'block-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

$block_class = '';
if( isset( $block['className'] ) && $block['className'] ) {
	$block_class = $block['className'] . ' ';
}

$items = array();

if( $articles && count( $articles ) ) {
	// loop through the rows of data
	foreach ( $articles as $article ) { 
		$items[] = $article;
	}
} else if( $category || $tag ) {
	if( $category ) {
		$argument = 'category__in';
		$args[$argument] = $category;
	}

	if( $tag ) {
		$argument = 'tag__in';
		$args[$argument] = $tag;
	}

	$args[ 'posts_per_page' ] = 4;
	$args[ 'order' ] = 'DESC';
	$args[ 'orderby' ] = 'date';
	$args[ 'fields' ] = 'ids';

	$items = new WP_Query($args);

}

$output = '<div id="' . $id . '" class="' . $block_class . $align_class . ' four-stories">';


if( $title || $articles || $category || $tag ) {


	if( $title ) {
		$output .= '<h2>' . esc_html( $title ) . '</h2>';
	}

	if( count( $items ) ) {
		$output .= '<ul class="stories">';
		foreach( $items as $key => $item ) {
			$link = get_permalink( $item );
			if( get_post_meta( $item, 'external_url', true ) ) {
				$link = get_post_meta( $item, 'external_url', true );
			}
			$output .= '<li><div class="wp-block-columns"><div class="wp-block-column">';
			$categories = get_the_category($item);
			if ( ! empty( $categories ) && isset( $categories[0] ) && isset( $categories[0]->name ) ) {
				$output .= '<div class="eyebrow">' . esc_html( $categories[0]->name ) . '</div>';
			}
			$output .= '<h3><a href="' . $link . '">' . esc_html( get_the_title( $item ) ) . '</a></h3>';	
			$output .= '<p>' . esc_html( get_the_excerpt( $item ) ) . '</p>';
			$output .= '</div>';
			if ( has_post_thumbnail( $item ) ) {
				$image_id  = get_post_thumbnail_id( $item );
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				if( $key ) {
					$image_url = pulpfree_image_resize( $image_id, 800, 450 );
				} else {
					$image_url = pulpfree_image_resize( $image_id, 1600, 900 );
				}
				$output .= '<div class="wp-block-column"><a href="' . $link . '"><img src="' . $image_url . '" alt="' . $image_alt . '"></a></div>';
			}
			$output .= '</div></li>';
		}
		$output .= '</ul>';
	}
	

} else {
	$output .= '<span class="hidden show-in-editor">Please add a title and choose articles using the block settings in the sidebar.</span>';
}

$output .= '</div>';


echo $output;

