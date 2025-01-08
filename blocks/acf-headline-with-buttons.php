<?php
/**
 * Block Name: Headline with Buttons
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

$group_id = 15174;
if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_headline_with_buttons';
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

// create id attribute for specific styling
$id = 'block-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

$block_class = '';
if( isset( $block['className'] ) && $block['className'] ) {
	$block_class = $block['className'] . ' ';
}

$output = '<div id="' . $id . '" class="' . $block_class . $align_class . ' headline-with-buttons background-' . $background_color . '"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';


if( $title || $description || $links ) {

	$output .= '<div class="wp-block-group intro"><div class="wp-block-group__inner-container is-layout-flow wp-block-group-is-layout-flow">';

	if( $title ) {
		$output .= '<h2 class="wp-block-heading">' . $title . '</h2>';
	}
	if( $description ) {
		$output .= '<div class="wrapper">';
		if( $description ) {
			$output .= $description;
		}
		$output .= '</div>';
	}

	$output .= '</div></div>';

	if(have_rows('links')) {
		$output .= '<div class="wp-block-buttons">';

		// loop through the rows of data
		while ( have_rows('links') ) { 
			the_row();

			$link = get_sub_field('link');

			$output .= '<div class="wp-block-button"><a href="' . $link['link'] . '"';
			if( isset( $link['target'] ) && $link['target'] ) {
				$output .= ' target="' . $link['target'] . '"';
			} 
			$output .= '>' . $link['title'] . '</a></div>';
		}
		$output .= '</div>';
	}

} else {

	$output .= '<span class="hidden show-in-editor">Please add a title, description, or at least one link to this block using the block settings in the sidebar.</span>';

}

$output .= '</div></div>';

echo $output;

