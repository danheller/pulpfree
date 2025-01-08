<?php
/**
 * Block Name: Interactive Content Pane
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

$group_id = 2518;
if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_interactive_content_pane';
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

$items = array();

// create id attribute for specific styling
$id = 'block-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

$block_class = '';
if( isset( $block['className'] ) && $block['className'] ) {
	$block_class = $block['className'] . ' ';
}

$output = '<div id="' . $id . '" class="' . $block_class . $align_class . ' photo-tabs"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';

if( $title || $cards ) {

	if(have_rows('cards')) {
		// loop through the rows of data
		while ( have_rows('cards') ) { 
			the_row();
			$item = array();
			$item['title'] = get_sub_field('title');
			$item['headline'] = get_sub_field('headline');
			$item['excerpt'] = get_sub_field('description');
			$item['img'] = get_sub_field('background_image');
			$item['links'] = get_sub_field('links');
			$items[] = $item;
			if( ! isset( $background_image ) || ! $background_image ) {
				$background_image = $item['img'];
			}
		}
	}

	if( $background_image ) {
		$output .= '<figure class="wp-block-image size-full background">' . pulpfree_wide_image( $background_image ) . '</figure>';
	}

	if( $title ) {
		$output .= '<div class="wp-block-group intro"><div class="wp-block-group__inner-container is-layout-flow wp-block-group-is-layout-flow"><h2 class="wp-block-heading">' . $title . '</h2>';
		if( isset( $intro ) && $intro ) {
			$output .= '<p>' . $intro . '</p>';
		}
		$output .= '</div></div>';
	}

	if( count( $items ) ) {
	
		$output .= '<div class="wp-block-group items"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';
	
		foreach( $items as $key => $item ) {
			$output .= '<div class="wp-block-group item"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained"><div class="wp-block-media-text is-stacked-on-mobile">';
			if( $item['img'] && is_int( $item['img'] ) ) {
				$output .= '<figure class="wp-block-media-text__media">' . pulpfree_wide_image( $item['img'] ) . '</figure>';
			} else if( $background_image ) {
				$output .= '<figure class="wp-block-media-text__media">' . pulpfree_wide_image( $background_image ) . '</figure>';			
			}
			$output .= '<div class="wp-block-media-text__content"><h3 class="wp-block-heading">' . $item['title'] . '</h3>';
			if( isset( $item['headline'] ) && $item['headline'] ) {
				$output .= '<h4>' . $item['headline'] . '</h4>';
			}
			$output .= '<p>' . $item['excerpt'] . '</p>';
			if( is_array( $item['links'] ) ) {
//				echo '<pre>';
//				print_r( $item['links'] );
//				echo '</pre>';

				foreach( $item['links'] as $link ) {
					$link = $link['link'];
					$output .= '<p class="call-to-action"><a href="' . $link['url'] . '"';
					if( isset( $link['target'] ) && $link['target'] ) {
						$output .= ' target="' . $link['target'] . '"';
					} 
					$output .= '>' . $link['title'] . '</a></p>';
				}
			}
			$output .= '</div></div></div></div>';
	
		}
		$output .= '</div></div>';
	}

} else {

	$output .= '<span class="hidden show-in-editor">Please add a title and/or at least one card to this block using the block settings in the sidebar.</span>';

}

$output .= '</div></div>';


echo $output;

