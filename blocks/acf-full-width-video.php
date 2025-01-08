<?php
/**
 * Block Name: Full-Width Video
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

$group_id = 15030;
if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_full_width_video';
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
$output = '<div id="' . $id . '" class="' . $block_class . $align_class . ' full-width-video">';

if( ! $video || ! $image ) {
	$output .= '<span class="hidden show-in-editor">Please add a video and image. You <strong>must</strong> choose an image placeholder or else this block will not appear.</span>';
} else {
	$image_url = pulpfree_image_resize( $image, 1600, 900 );
	$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
	$output .= '<figure class="wp-block-image size-full"><img src="' . $image_url . '" alt="' . $image_alt . '"></figure>';
	$output .= '<a class="video-link" href="' . esc_attr( $video ) . '">' . __('Watch video', 'pulpfree') . '</a>';
	
}
$output .= '</div>';

echo $output;

