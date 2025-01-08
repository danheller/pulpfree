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

$group_id = 3802;
 if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_social_links';
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

$output = '<div id="' . $id . '" class="' . $block_class . $align_class . ' social-links"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">';

if( $title || $social_links ) {

	if(have_rows('links')) {
		// loop through the rows of data
		while ( have_rows('links') ) { 
			the_row();
			$item = array();
			$item['network'] = get_sub_field('network');
			$item['link'] = get_sub_field('link');

			$items[] = $item;
		}
	}

	if( $title || $items ) {
		$output .= '<div class="links">';
		if( $title ) {
			$output .= '<h2 class="wp-block-heading">' . esc_html( $title ) . '</h2>';
			if( isset( $description ) && $description ) {
				$output .= '<p>' . $description . '</p>';
			}
		}

		if( count( $items ) ) {
		
			$output .= '<ul>';
		
			foreach( $items as $key => $item ) {
				$output .= '<li><a href="' . esc_attr( $item['link'] ) . '" data-network="' . esc_attr( $item['network'] ) . '" title="visit us on ' . $item['network'] . '">' . $item['network'] . '</a></li>';
			}
			$output .= '</ul>';
		}
		$output .= '</div>';
	}
	
	if( $promo ) {
		$output .= '<div class="promo">';
		if( $promo['title'] ) {
			$output .= '<h2 class="wp-block-heading">' . esc_html( $promo['title'] ) . '</h2>';
			if( isset( $promo['message'] ) && $promo['message'] ) {
				$output .= '<p>' . $promo['message'] . '</p>';
			}
		}
		if( $promo['link'] ) {
			$link = $promo['link']['link'];
			$output .= '<p class="call-to-action"><a class="link" href="' . $link['url'] . '"';
			if( isset( $link['target'] ) && $link['target'] ) {
				$output .= ' target="' . $link['target'] . '"';
			} 
			$output .= '>' . $link['title'] . '</a></p>';
		}

		$output .= '</div>';
	}

} else {

	$output .= '<span class="hidden show-in-editor">Please add a title or at least one link to this block using the block settings in the sidebar.</span>';

}

$output .= '</div></div>';

echo $output;

