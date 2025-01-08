<?php
/**
 * Block Name: Featured Video
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

$group_id = 15061;
if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_featured_video';
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

if( $video_width && 'default' != $video_width ) {
	$align_class .= ' video-width-' . $video_width;
}

$block_class = '';
if( isset( $block['className'] ) && $block['className'] ) {
	$block_class = $block['className'] . ' ';
}

$output = '<div id="' . $id . '" class="' . $block_class . $align_class . ' wp-block-media-text is-stacked-on-mobile is-style-wide-image featured-video';

if( $alignment && 'right' == $alignment ) {
	$output .= ' has-media-on-the-right">';
} else {
	$output .= '">';
}
		
if( ! $video || ! $image ) {
	$output .= '<span class="hidden show-in-editor">Please add a video and image. You <strong>must</strong> choose an image placeholder or else this block will not appear.</span>';
} else {

	$content = '<div class="wp-block-media-text__content">';
	if( $title ) {
		$content .= '<h2 class="wp-block-heading">' . esc_html( $title ) . '</h2>';
	}
	if( $description ) {
		$content .= $description;
	}
	$content .= '</div>';

	$image_url = pulpfree_image_resize( $image, 1600, 900 );
	$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
	$figure = '<figure class="wp-block-media-text__media"><img src="' . $image_url . '" alt="' . $image_alt . '"><a class="video-link" href="' . esc_attr( $video ) . '">' . __('Watch video', 'pulpfree') . '</a></figure>';

	$output .= '<div id="' . $id . '" class="' . $block_class . $align_class . ' wp-block-media-text is-stacked-on-mobile is-style-wide-image featured-video';

	if( $alignment && 'right' == $alignment ) {
		$output .= $content . $figure;
	} else {
		$output .= $figure . $content;
	}
}

$output .= '</div>';

echo $output;
