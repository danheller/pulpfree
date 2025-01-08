<?php
/**
 * Block Name: Call To Action Cards
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

$group_id = 2700;
if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_cta_card_collection';
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

$output = '<div id="' . $id . '" class="' . $block_class . $align_class . ' cta-cards background-' . $background_color . '"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';

if( $title || $cards ) {
	if(have_rows('cards')) {
		// loop through the rows of data
		while ( have_rows('cards') ) { 
			the_row();
			$item['title'] = get_sub_field('title');
			$item['description'] = get_sub_field('description');
			$item['link'] = get_sub_field('link');
			$items[] = $item;
		}
	}
	
//	print_r($items);

	$output .= '<div class="wp-block-group intro"><div class="wp-block-group__inner-container is-layout-flow wp-block-group-is-layout-flow">';

	if( $title ) {
		$output .= '<h2 class="wp-block-heading">' . $title . '</h2>';
		if( $description || $link ) {
			$output .= '<div class="wrapper">';
			if( $description ) {
				$output .= '<p>' . $description . '</p>';
			}
			if( $link ) {
				$output .= '<p class="link"><a href="' . $link['url'] . '"';
				if( isset( $link['target'] ) && $link['target'] ) {
					$output .= ' target="' . $link['target'] . '"';
				} 
				$output .= '>' . $link['title'] . '</a></p>';
			}
			$output .= '</div>';
		}
	}
	$output .= '</div></div>';

	if( count( $items ) ) {
	
		$output .= '<div class="wp-block-group cards"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';
	
		foreach( $items as $key => $item ) {
			$output .= '<div class="wp-block-group item"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';

			if( isset( $item['title'] ) && $item['title'] ) {
				$output .= '<h3>';
				if( isset( $item['link'] ) && $item['link'] ) {
					$output .= '<a href="' . $item['link'] . '">';
				} else {
					$output .= '<span class="no-link">';
				}
				$output .= $item['title'];
				if( isset( $item['link'] ) && $item['link'] ) {
					$output .= '</a>';
				} else {
					$output .= '</span>';
				}	
				$output .= '</h3>';
			}

			if( isset( $item['description'] ) && $item['description'] ) {
				$output .= '<p>' . $item['description'] . '</p>';
			}
			$output .= '</div></div>';
	
		}
		$output .= '</div></div>';
	}

} else {

	$output .= '<span class="hidden show-in-editor">Please add a title and/or at least one card to this block using the block settings in the sidebar.</span>';

}

$output .= '</div></div>';

echo $output;

