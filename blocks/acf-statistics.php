<?php
/**
 * Block Name: Statistics
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

$group_id = 2547;
 if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_statistics';
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

$output = '<div id="' . $id . '" class="' . $block_class . $align_class . ' statistics"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';

if( $title || $statistics ) {

	if(have_rows('statistics')) {
		// loop through the rows of data
		while ( have_rows('statistics') ) { 
			the_row();
			$item = array();
			$item['title'] = get_sub_field('title');
			$item['description'] = get_sub_field('description');
			$item['footnote'] = get_sub_field('footnote');
			$items[] = $item;
		}
	}

	if( $title ) {
		$output .= '<h2 class="wp-block-heading">' . $title . '</h2>';
		if( isset( $description ) && $description ) {
			$output .= '<p>' . $description . '</p>';
		}
	}

	if( count( $items ) ) {
	
		$output .= '<div class="wp-block-group items"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';
	
		foreach( $items as $key => $item ) {
			$output .= '<div class="wp-block-group item"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';
			$output .= '<h3 class="wp-block-heading">' . $item['title'] . '</h3>';
			$output .= '<p>' . $item['description'] . '</p>';
			if( isset( $item['footnote'] ) && $item['footnote'] ) {
				$output .= '<p class="footnote">' . $item['footnote'] . '</p>';
			}
			$output .= '</div></div>';
		}
		$output .= '</div></div>';
	}

} else {

	$output .= '<span class="hidden show-in-editor">Please add a title and/or at least one statistic to this block using the block settings in the sidebar.</span>';

}

$output .= '</div></div>';

echo $output;

