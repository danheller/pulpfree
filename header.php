<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pulpfree
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php pulpfree_schema_type(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="https://gmpg.org/xfn/11">
		<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/uscshield.png" />
		<?php
			$pulpfree_description = get_bloginfo( 'description', 'display' );
			if ( $pulpfree_description ) {
			?>
		<meta name="description" content="<?php echo esc_attr( $pulpfree_description ); ?>">
			<?php
			}
			$menu_photo = get_option('menu_photo');
			if( $menu_photo ) {
			?>
			<style type="text/css">
				:root {
					--menu-photo: url(<?php echo $menu_photo; ?>);
				}
			</style>
		<?php
			}
			wp_head(); 
		?>
	</head>

	<body <?php global $bodyclass; body_class($bodyclass); ?> data-basehref="<?php echo esc_attr( home_url() ); ?>">
	<?php wp_body_open(); ?>
	<div id="wrapper" class="site-wrapper">

		<header class="site-header<?php if( isset( $GLOBALS['header_version'] ) && $GLOBALS['header_version'] ) { echo ' ' . $GLOBALS['header_version']; } ?>" role="banner">
			<div class="branding">
				<div class="site-title">
					<a class="usc-logo" href="http://www.usc.edu"><span class="screen-reader-text" id="usc-name">University of Southern California</span><svg role="img" aria-labelledby="usc-name" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 178 58" style="enable-background:new 0 0 178 58;" xml:space="preserve">
<path class="red white" d="M59.8,11.2c0-2.3-0.5-3.3-2.3-3.3h-3.1c-0.4,0-0.5-0.1-0.5-0.6V5.8c0-0.4,0.1-0.5,0.7-0.5 c0.7,0,3.9,0.2,10.3,0.2c5.6,0,8.8-0.2,9.6-0.2c0.4,0,0.5,0.1,0.5,0.5v1.7c0,0.4-0.1,0.5-0.5,0.5h-2.8c-2,0-3.2,1.2-3.3,2.6 c-0.1,0.8-0.2,4.8-0.2,8.7v8.3c0,3.3,0.1,8.1,0.2,10.2c0.2,3.1,0.7,6.1,2.3,8.3c2.3,3.1,5.9,4.1,9.1,4.1c3.1,0,6.8-1.2,9-3.2 c2.5-2.5,3.9-6.4,3.9-11.3v-12c0-5.3-0.5-11.2-0.7-12.8c-0.2-1.7-1.3-2.9-2.7-2.9h-2.4c-0.4,0-0.5-0.2-0.5-0.5V5.8 c0-0.4,0.1-0.5,0.5-0.5c0.7,0,3.7,0.2,8.1,0.2c4.1,0,6.3-0.2,6.8-0.2c0.6,0,0.7,0.2,0.7,0.5v1.5c0,0.4-0.1,0.6-0.4,0.6h-2.4 c-2.4,0-2.7,1.9-2.8,2.6c-0.1,0.8-0.1,10.2-0.1,11c0,0.9-0.1,12.6-0.4,15.2c-0.4,5.5-2,9.6-5.6,12.8c-2.8,2.5-7.1,4.1-12.2,4.1 c-3.2,0-7.1-0.5-9.6-1.6c-3.9-1.6-6.5-4.7-7.9-9c-0.9-2.9-1.2-7.3-1.2-16.1V11.2z"></path>
<path class="red white" d="M104.3,37.8c0.3,0,0.4,0.1,0.4,0.5c0.1,2.1,0.7,4.7,2.5,7.6c2,3.2,5.5,4.8,8.8,4.8 c3.6,0,8.7-2.3,8.7-7.8c0-6.1-2.8-8.1-9.9-10.8c-2.1-0.8-6.5-2.7-9.8-5.6c-2.3-2.1-3.3-5.5-3.3-9.6c0-3.7,1.5-6.8,4.7-9.4 c2.7-2.3,5.6-3.2,9.5-3.2c4.4,0,7.1,1.1,8.4,1.6c0.7,0.3,1.1,0.1,1.4-0.2l0.9-0.9c0.3-0.3,0.5-0.4,0.9-0.4c0.4,0,0.5,0.4,0.5,1.1 c0,1.1,1.1,10.4,1.1,11.1c0,0.3-0.1,0.4-0.4,0.5l-1.1,0.3c-0.3,0.1-0.5,0-0.7-0.4c-0.7-1.9-1.7-4.5-4.1-7.1 c-1.7-1.9-3.9-2.8-6.9-2.8c-5.3,0-7.5,4.3-7.5,6.7c0,2.3,0.3,4.3,1.9,6c1.7,1.7,5.5,3.3,8.1,4.1c3.9,1.2,7.1,2.5,9.6,5.2 c2.1,2.3,3.3,5.1,3.3,9.6c0,8.1-5.3,14.8-14.2,14.8c-5.5,0-8.7-1.2-11.4-3.2c-0.8-0.5-1.2-0.8-1.6-0.8c-0.4,0-0.7,0.5-1.1,1.2 c-0.4,0.7-0.7,0.8-1.2,0.8c-0.5,0-0.8-0.4-0.8-1.1c0.1-0.8,1.1-11.6,1.2-12.4c0.1-0.4,0.1-0.5,0.4-0.5L104.3,37.8z"></path>
<path class="red white" d="M177.1,41.8c0.2,0.2,0.3,0.4,0.1,0.7c-4,5.7-10.4,11.2-19.9,11.2c-8.6,0-13.4-2.5-17.5-6.3 c-4.9-4.4-7.2-12.2-7.2-18c0-6.5,2.1-12.8,6.8-17.9c3.6-3.9,9.3-7.1,17.4-7.1c6.1,0,11.1,1.9,13.5,3.2c0.9,0.5,1.2,0.5,1.3,0 l0.5-1.7c0.1-0.4,0.3-0.4,1.1-0.4c0.8,0,0.9,0.1,0.9,1.1c0,1.2,1.3,11.9,1.6,13.9c0.1,0.4,0,0.6-0.3,0.7l-1.3,0.4 c-0.3,0.1-0.5-0.1-0.7-0.7c-0.8-2.4-2.4-5.7-5.2-8.7c-2.9-2.8-6.4-4.9-11.6-4.9c-10.7,0-15.1,9.6-15.1,19.2c0,4.1,1.2,12,6.1,17.4 c4.4,4.7,8.3,5.2,11.5,5.2c7.3,0,13.2-3.7,16-7.7c0.3-0.5,0.6-0.7,0.8-0.5L177.1,41.8z"></path>
<path class="black white" d="M39.7,35.3C37,41.9,31.8,51,22.4,56.7C13,51,7.8,42,5.1,35.4c-2.5-6.1-3.4-11.3-3.7-12.8 c1.1-0.6,2.2-0.9,3.5-0.9h0c0.9,0,2.1,0.2,2.9,0.4l0.4,0.1c0.4,0.1,0.8,0.2,1.2,0.3c1.4,0.4,3,0.8,4.1,0.8h0c1.3,0,3.4-0.2,5.7-1 c0.7-0.2,1.5-0.5,2.3-0.6l0.8-0.1h0l1.2,0.1c0.7,0.1,1.4,0.3,2,0.5c2.3,0.8,4.4,1,5.7,1h0c0.8,0,1.8-0.2,3.3-0.6 c0.6-0.2,1.2-0.3,1.8-0.5l0.7-0.2c0.7-0.2,2-0.4,2.9-0.4h0c1.3,0,2.4,0.3,3.5,0.9C43.1,24,42.2,29.2,39.7,35.3L39.7,35.3z M0.8,12.7 l13.7,3c-0.1,0.2-0.2,0.4-0.3,0.6L0.8,14.6C0.8,14,0.8,13.3,0.8,12.7L0.8,12.7z M1.3,7.7l14.2,6.6c-0.3,0.3-0.5,0.6-0.7,1L0.9,11.4 C1,10.2,1.1,9,1.3,7.7L1.3,7.7z M1.7,5.6c0.5,0.1,1.6,0.3,3,0.5l11.5,7.4c-0.2,0.1-0.3,0.3-0.4,0.4L1.5,6.3C1.6,6.1,1.6,5.8,1.7,5.6 L1.7,5.6z M7.8,6.2c1.5,0,2.9-0.1,4.2-0.4l5.8,6.5c-0.4,0.3-0.9,0.5-1.2,0.9l-9.6-7C7.2,6.2,7.5,6.2,7.8,6.2L7.8,6.2z M15.2,5 l3.9,6.8c-0.3,0.1-0.5,0.2-0.8,0.3l-4.9-6.6C14,5.4,14.6,5.2,15.2,5L15.2,5z M20.3,2.5l1.2,8.7c-0.7,0.1-1.3,0.2-1.9,0.4l-3.2-7 C18,3.9,19.3,3.2,20.3,2.5L20.3,2.5z M22.3,1c0.3,0.2,0.6,0.5,0.9,0.7l-0.5,9.4c-0.1,0-0.2,0-0.3,0h0c-0.1,0-0.2,0-0.3,0l-0.5-9.5 C21.9,1.4,22.2,1.2,22.3,1L22.3,1z M24.4,2.5c1.4,0.9,2.7,1.6,3.9,2l-3.2,7c-0.6-0.2-1.2-0.3-1.9-0.4L24.4,2.5z M29.4,5 c0.8,0.3,1.5,0.5,1.8,0.5l-4.9,6.6c-0.2-0.1-0.5-0.2-0.8-0.3L29.4,5z M32.7,5.8c1.4,0.3,2.9,0.4,4.5,0.4c0.2,0,0.4,0,0.5,0l-9.6,7 c-0.4-0.3-0.8-0.6-1.2-0.9L32.7,5.8z M39.9,6.1c1.5-0.1,2.5-0.4,3.1-0.5c0.1,0.2,0.1,0.5,0.1,0.7l-14.3,7.6 c-0.1-0.2-0.3-0.3-0.5-0.4L39.9,6.1z M43.4,7.7c0.2,1.3,0.3,2.6,0.4,3.8L30,15.3c-0.2-0.4-0.5-0.7-0.8-1.1L43.4,7.7z M43.9,14.6 l-13.3,1.8c-0.1-0.2-0.2-0.4-0.3-0.6l13.6-3C43.9,13.4,43.9,14,43.9,14.6L43.9,14.6z M39.9,17.4c-0.8,0-2.2,0.2-3.1,0.4L36.1,18 c-0.6,0.2-1.2,0.4-1.8,0.5c-0.8,0.2-2,0.5-2.9,0.5c-0.1-0.8-0.3-1.5-0.6-2.3l13.1-1c0,0.9-0.1,1.8-0.1,2.5 C42.6,17.8,41.2,17.5,39.9,17.4L39.9,17.4z M39.8,19.1L39.8,19.1c-0.9,0-2.3,0.2-3.1,0.4l-0.6,0.2c-0.6,0.2-1.2,0.4-1.8,0.5l0.1,0.4 l-0.1-0.4c-0.9,0.2-2.1,0.5-3.1,0.5h0c-1.3,0-3.2-0.2-5.5-0.9c-0.6-0.2-1.3-0.4-2.1-0.6c-0.4-0.1-0.9-0.1-1.3-0.1 c-0.3,0-0.6,0-0.9,0.1c-0.9,0.1-1.8,0.4-2.5,0.6c-2.2,0.8-4.2,0.9-5.5,1h0c-1.1,0-2.6-0.4-3.9-0.8L8,19.6c-0.8-0.2-2.1-0.4-3.1-0.4 h0c-1.3,0-2.6,0.3-3.8,0.9C1,19.8,1,19.6,1,19.3c1.2-0.6,2.6-1,4-1h0c0.9,0,2.1,0.2,2.9,0.4l1.6,0.5l0.1-0.4l-0.1,0.4 c1.5,0.4,3,0.8,4.1,0.8h0c1.3,0,3.4-0.2,5.7-1c0.7-0.2,1.5-0.5,2.3-0.6l0.8-0.1l1.2,0.1c0.7,0.1,1.4,0.4,2,0.5c2.3,0.8,4.4,1,5.7,1 h0c0.8,0,1.8-0.2,3.3-0.6c0.6-0.2,1.2-0.3,1.8-0.5l0.6-0.2c0.7-0.2,2-0.4,2.9-0.4h0c1.3,0,2.7,0.3,3.9,0.9c0,0.3-0.1,0.6-0.1,0.9 C42.5,19.4,41.1,19.1,39.8,19.1L39.8,19.1z M22.4,17.5L22.4,17.5L22.4,17.5c-0.3,0-0.6,0-0.9,0.1c-0.9,0.1-1.8,0.4-2.5,0.6 c-1.9,0.7-3.6,0.9-4.9,0.9c0.6-4.1,4-7.2,8.2-7.2h0c4.1,0,7.7,3.1,8.2,7.1c-1.2-0.1-2.9-0.3-4.8-0.9c-0.6-0.2-1.3-0.4-2.1-0.6l0,0 l0,0C23.2,17.5,22.8,17.5,22.4,17.5L22.4,17.5z M0.8,15.8l13.1,1c-0.3,0.7-0.5,1.5-0.6,2.3c-1.1,0-2.5-0.4-3.7-0.8L8,17.9 c-0.8-0.2-2.1-0.4-3.1-0.4h0c-1.4,0-2.8,0.3-4.1,0.9C0.9,17.7,0.8,16.8,0.8,15.8L0.8,15.8z M39.8,20.8L39.8,20.8 c-0.9,0-2.3,0.2-3.1,0.4L36,21.4c-0.6,0.2-1.2,0.3-1.7,0.5l0.1,0.4l-0.1-0.4c-1.4,0.4-2.3,0.5-3.1,0.5h0c-1.3,0-3.2-0.2-5.5-0.9 c-0.6-0.2-1.3-0.4-2.1-0.6c-0.8-0.1-1.5-0.2-2.2-0.1c-0.9,0.1-1.8,0.4-2.5,0.6c-2.2,0.8-4.2,0.9-5.5,1h0c-1.1,0-2.6-0.4-3.9-0.8 l-0.1,0.4l0.1-0.4c-0.4-0.1-0.8-0.2-1.2-0.3L8,21.3c-0.8-0.2-2.1-0.4-3.1-0.4h0c-1.3,0-2.5,0.3-3.6,0.9c0-0.2-0.1-0.5-0.1-0.8 c1.1-0.6,2.4-1,3.7-1h0c0.9,0,2.1,0.2,2.9,0.4l1.6,0.5l0.1-0.4l-0.1,0.4c1.5,0.4,3,0.8,4.1,0.8h0c1.3,0,3.4-0.2,5.7-1 c0.7-0.2,1.5-0.5,2.3-0.6l0.8-0.1h0l1.2,0.1c0.7,0.1,1.4,0.4,2,0.5c2.3,0.8,4.4,1,5.7,1h0c0.8,0,1.8-0.2,3.3-0.6 c0.6-0.2,1.2-0.3,1.8-0.5l0.6-0.2c0.7-0.2,2-0.4,2.9-0.4h0c1.3,0,2.6,0.3,3.8,1c0,0.3-0.1,0.6-0.1,0.8 C42.3,21.1,41.1,20.8,39.8,20.8L39.8,20.8z M44.7,12.6l-0.1-1.3c-0.1-1.2-0.2-2.6-0.5-3.9L44,6.4c-0.1-0.5-0.2-1-0.3-1.5l-0.1-0.4 l-0.4,0.1c0,0-0.7,0.2-1.7,0.4l-2.6,0.3c-0.5,0-1.1,0.1-1.7,0.1c-1.5,0-3-0.1-4.5-0.4l-0.9-0.2c0,0,0,0,0,0c0,0-0.8-0.2-1.9-0.5 l-1.2-0.5c-1.2-0.5-2.7-1.2-4.1-2.2l-1.2-0.9c-0.2-0.2-0.4-0.4-0.7-0.6L22.3,0l-0.3,0.2c0,0-0.2,0.2-0.6,0.5l-1.2,0.9 c-1,0.7-2.4,1.5-4.2,2.2l-1.2,0.5c-0.6,0.2-1.2,0.4-1.9,0.6c0,0,0,0,0,0l-1.1,0.2c-1.3,0.2-2.6,0.4-4,0.4c-0.7,0-1.4,0-2-0.1 L3.2,5.1c-1-0.2-1.7-0.3-1.7-0.3L1.1,4.6L1,5C0.9,5.4,0.8,5.8,0.8,6.2L0.6,7.4C0.4,8.7,0.2,10,0.1,11.2L0,12.5c0,0.7,0,1.3,0,1.9 l0,1.3c0.1,3.7,0.5,6.2,0.5,6.4c0,0.3,0.8,6.3,3.8,13.4c2.8,6.7,8.1,15.9,17.7,21.7l0.4,0.3l0.4-0.3c9.6-5.8,14.8-15.1,17.6-21.8 c2.9-7.2,3.7-13.1,3.7-13.4c0-0.2,0.5-2.7,0.5-6.4l0-1.3C44.7,13.9,44.7,13.2,44.7,12.6L44.7,12.6z"></path>
<path class="black white" d="M33.5,31c-0.1,0.1-0.3,0.2-0.4,0.2l-3,0c-0.4,0-0.6-0.3-0.6-0.6c0-0.3,0.3-0.6,0.6-0.6l0.5,0 c0,0,0,0,0,0l0,0h0.6l1.8,0c0.3,0,0.6,0.3,0.6,0.6C33.7,30.7,33.6,30.9,33.5,31L33.5,31z M32.9,32.1c-0.1,0.1-0.3,0.2-0.5,0.2 l-1.8,0c-0.3,0-0.5-0.2-0.6-0.6c0,0,0,0,0,0l3,0c0,0,0,0,0,0C33,31.8,33,32,32.9,32.1L32.9,32.1z M32.1,39.7l-1.2,0l-0.3-7l1.8,0 c0,0,0,0,0,0L32.1,39.7z M32.9,40.7c0,0.3-0.2,0.5-0.5,0.5l-1.7,0l0,0.2v-0.2c-0.3,0-0.5-0.2-0.5-0.5c0-0.3,0.2-0.5,0.5-0.5l1,0 l0.8,0C32.7,40.2,32.9,40.4,32.9,40.7L32.9,40.7z M31.5,45.1c-0.2,0-0.4-0.2-0.4-0.4l-0.1-3h1l-0.1,3C31.9,44.9,31.7,45.1,31.5,45.1 L31.5,45.1z M29.1,28.4c0-0.4,0.2-0.7,0.3-1.1c0.2-0.4,0.4-0.9,0.3-1.4c0.3,0.1,0.7,0.3,0.9,0.6c0,0,0,0,0,0 c-0.1,0.1-0.1,0.2-0.2,0.2c0,0-1.2,1.2-0.4,2.7H30c-0.1,0-0.2,0-0.3,0C29.7,29.4,29.1,29.2,29.1,28.4L29.1,28.4z M31.7,25.9 c0.1-0.2,0.1-0.4,0-0.6c0.5,0.4,1.1,1.1,1.1,2c0,1-0.7,1.9-0.9,2.1h-0.2c-0.2-0.3-0.6-0.9-0.2-1.7c0.1-0.1,0.5-0.8,0.5-0.9 c0.1-0.1,0.1-0.3,0.1-0.3c-0.1,0.1-0.2,0.2-0.2,0.2c-0.1,0.1-0.5,0.5-0.6,0.7c-0.6,0.8-0.2,1.6,0,1.9l-0.6,0 c-0.9-1.3,0.1-2.3,0.1-2.3C31,27,31,27,31.1,26.9C31.4,26.6,31.6,26.4,31.7,25.9L31.7,25.9z M33.1,26.3c0.2-0.2,0.4-0.4,0.5-0.5 c-0.1,1.1,0.4,2.2,0.5,2.2c0.3,0.9-0.7,1.4-0.9,1.5c-0.1,0-0.2,0-0.3,0h-0.5c0.3-0.5,0.8-1.2,0.8-2.1C33.3,26.9,33.1,26.3,33.1,26.3 L33.1,26.3z M33.8,29.7c0.5-0.3,1.1-1,0.8-1.9c0,0-0.7-1.3-0.3-2.3l0.1-0.3l-0.4,0c-0.1,0-0.5,0.1-1.1,0.7c-0.6-0.9-1.5-1.5-1.5-1.5 l-0.9-0.5l0.6,0.9c0.1,0.2,0.4,0.7,0.3,1c-0.1,0.2-0.1,0.3-0.2,0.5c-0.6-0.6-1.5-0.9-1.6-0.9L29,25.2l0.2,0.4c0.3,0.6,0.1,1-0.2,1.5 c-0.2,0.4-0.4,0.8-0.4,1.3c0,0.7,0.3,1.1,0.6,1.3c-0.2,0.2-0.4,0.5-0.4,0.8c0,0.4,0.2,0.8,0.6,1c0.1,0.6,0.3,0.9,0.6,1.1l0.3,7.2 c-0.4,0.1-0.8,0.5-0.8,0.9c0,0.5,0.4,0.9,0.8,1l0.1,3c0,0.5,0.4,0.8,0.8,0.8c0.5,0,0.8-0.4,0.8-0.8l0.1-3c0.5-0.1,0.9-0.5,0.9-1 c0-0.5-0.3-0.9-0.8-0.9l0.3-7.2c0.1,0,0.2-0.1,0.3-0.2c0.2-0.2,0.3-0.5,0.4-0.9c0.1,0,0.2-0.1,0.2-0.2c0.2-0.2,0.3-0.5,0.3-0.8 C34.1,30.2,34,29.9,33.8,29.7L33.8,29.7z"></path>
<path class="black white" d="M14.5,31.2l-3,0c-0.4,0-0.6-0.3-0.6-0.6c0-0.2,0.1-0.3,0.2-0.4c0.1-0.1,0.3-0.2,0.4-0.2H12 c0,0,0,0,0,0l0,0h0.6l0.9,0h0.9c0.3,0,0.6,0.3,0.6,0.6C15.1,30.9,14.8,31.2,14.5,31.2L14.5,31.2z M14.3,32.1 c-0.1,0.1-0.3,0.2-0.5,0.2l-1.8,0c-0.3,0-0.5-0.2-0.6-0.6c0,0,0,0,0,0l3,0c0,0,0,0,0.1,0C14.5,31.9,14.4,32,14.3,32.1L14.3,32.1z M13.6,39.8l-1.2,0l-0.3-7h0l1.8,0c0,0,0,0,0,0L13.6,39.8z M14.4,40.8c0,0.1-0.1,0.3-0.2,0.4c-0.1,0.1-0.2,0.2-0.4,0.2h-1.7l0,0.2 v-0.2c-0.3,0-0.5-0.2-0.5-0.5c0-0.3,0.2-0.5,0.5-0.5h1l0.7,0C14.1,40.2,14.4,40.5,14.4,40.8L14.4,40.8z M13,45.1 c-0.2,0-0.4-0.2-0.4-0.4l-0.1-3l1,0l-0.1,3C13.4,44.9,13.2,45.1,13,45.1L13,45.1z M10.6,28.5c0-0.4,0.2-0.7,0.3-1.1 c0.2-0.4,0.4-0.9,0.3-1.4c0.3,0.1,0.7,0.3,0.9,0.6c0,0,0,0,0,0c-0.1,0.1-0.1,0.1-0.2,0.2c0,0-1.2,1.2-0.4,2.7h-0.1 c-0.1,0-0.1,0-0.2,0C11.2,29.5,10.6,29.2,10.6,28.5L10.6,28.5z M13.2,25.9c0.1-0.2,0.1-0.4,0-0.6c0.5,0.4,1.1,1.1,1.1,2 c0,1-0.7,1.9-0.9,2.1h-0.2c-0.2-0.3-0.6-0.9-0.2-1.7c0.1-0.1,0.5-0.8,0.5-0.9c0.1-0.1,0.1-0.3,0.1-0.3c-0.1,0.1-0.2,0.2-0.2,0.2 c-0.1,0.1-0.5,0.5-0.6,0.7c-0.6,0.8-0.2,1.6,0,1.9l-0.6,0c-0.9-1.3,0.1-2.3,0.1-2.3c0.1-0.1,0.1-0.2,0.2-0.2 C12.8,26.6,13,26.4,13.2,25.9L13.2,25.9z M14.6,26.3c0.2-0.2,0.4-0.4,0.5-0.5C15,26.9,15.6,28,15.6,28c0.3,0.9-0.7,1.4-0.9,1.5 c-0.1,0-0.2,0-0.3,0H14c0.3-0.5,0.8-1.2,0.8-2.1C14.8,26.9,14.6,26.3,14.6,26.3L14.6,26.3z M15.2,29.8c0.5-0.3,1.1-1,0.8-1.9 c0,0-0.7-1.3-0.4-2.3l0.1-0.3l-0.4,0c-0.1,0-0.5,0.1-1.1,0.7c-0.6-0.9-1.5-1.5-1.5-1.5l-0.9-0.5l0.6,0.9c0.1,0.2,0.4,0.7,0.3,1 c-0.1,0.2-0.1,0.3-0.2,0.4c-0.6-0.6-1.5-0.9-1.6-0.9l-0.5-0.1l0.2,0.4c0.3,0.6,0.1,1-0.2,1.5c-0.2,0.4-0.4,0.8-0.4,1.3 c0,0.7,0.4,1.1,0.6,1.3c0,0,0,0,0,0c-0.2,0.2-0.3,0.5-0.3,0.8c0,0.4,0.2,0.8,0.6,1c0,0.5,0.3,0.9,0.6,1.1l0.3,7.2 c-0.4,0.1-0.8,0.5-0.8,0.9c0,0.5,0.4,0.9,0.8,1l0.1,3c0,0.5,0.4,0.8,0.8,0.8c0.5,0,0.8-0.4,0.8-0.8l0.1-3c0.2,0,0.4-0.1,0.6-0.3 c0.2-0.2,0.3-0.4,0.3-0.7c0-0.5-0.3-0.9-0.8-0.9l0.3-7.2c0.1,0,0.2-0.1,0.3-0.2c0.2-0.2,0.3-0.5,0.3-0.9c0.3-0.2,0.6-0.5,0.6-1 C15.6,30.3,15.4,30,15.2,29.8L15.2,29.8z"></path>
<path class="black white" d="M25.1,32.4c-0.2,0.2-0.4,0.3-0.7,0.3l-4.2,0c-0.5,0-1-0.4-1-1c0-0.5,0.4-1,1-1c0,0,2.8,0,2.8,0 h1.4c0.5,0,1,0.4,1,1C25.4,32,25.3,32.2,25.1,32.4L25.1,32.4z M23.6,34l-2.5,0h0c-0.4,0-0.8-0.4-0.9-0.9c0,0,0.1,0,0.1,0l4.2,0 c0.1,0,0.1,0,0.2,0C24.4,33.6,24,34,23.6,34L23.6,34z M23.3,44.6l-1.9,0L21,34.5c0,0,0.1,0,0.1,0h0l2.5,0c0.1,0,0.1,0,0.2,0 L23.3,44.6z M24.4,45.9c0,0.4-0.4,0.8-0.8,0.8l-2.4,0c-0.4,0-0.8-0.4-0.8-0.8c0-0.4,0.4-0.8,0.8-0.8l1.8,0h0.6 C24,45.1,24.4,45.5,24.4,45.9L24.4,45.9z M23,51.5c0,0.2-0.1,0.3-0.2,0.4c-0.1,0.1-0.3,0.2-0.4,0.2h0c-0.2,0-0.3-0.1-0.4-0.2 c-0.1-0.1-0.2-0.3-0.2-0.4l-0.2-4.2l1.6,0L23,51.5z M18.9,28.7c0-0.6,0.2-1,0.5-1.5c0.3-0.6,0.6-1.3,0.4-2.1c0.4,0.2,1,0.4,1.5,0.9 c-0.1,0.1-0.1,0.1-0.2,0.2c-0.1,0.1-0.2,0.2-0.3,0.3c0,0-1.7,1.7-0.4,3.7h-0.2c-0.1,0-0.2,0-0.4,0.1C19.8,30.3,18.9,29.9,18.9,28.7 L18.9,28.7z M22.4,25.2c0.1-0.4,0.1-0.8,0-1.1c0.7,0.6,1.8,1.7,1.8,3.1c0,1.5-1,2.7-1.4,3.1h-0.1c-0.2-0.3-0.4-0.8-0.4-1.3 c0-1,0.5-1.6,0.5-1.6s-0.6,0.4-0.8,1.4c-0.1,0.5,0,0.9,0.3,1.6h-0.6c-0.2-0.3-0.9-1.3-0.2-2.4c0.1-0.2,0.8-1,0.8-1.2 c0.1-0.2,0.1-0.4,0.1-0.4c-0.1,0.2-0.3,0.3-0.3,0.3c-0.2,0.2-0.7,0.7-0.9,0.9c-1,1.2-0.2,2.5,0,2.8h-0.4c-1.4-1.9,0.1-3.3,0.2-3.4 c0.1-0.1,0.2-0.2,0.3-0.3C21.8,26.1,22.2,25.8,22.4,25.2L22.4,25.2z M25.4,25.4c-0.3,1.5,0.2,2.7,0.2,2.7c0.4,1.3-0.6,2-0.9,2.2 c-0.1,0-0.2,0-0.3,0l-0.9,0c0.5-0.6,1.2-1.7,1.2-3.1c0-0.4-0.1-0.7-0.2-1C24.8,25.7,25.2,25.5,25.4,25.4L25.4,25.4z M25.2,30.5 c0.5-0.4,1.2-1.2,0.8-2.6c0,0-0.5-1.4-0.1-2.9l0.1-0.3l-0.4,0c0,0-0.7,0.1-1.4,0.9c-0.7-1.5-2.3-2.4-2.3-2.5l-0.8-0.5l0.5,0.8 c0,0,0.5,0.9,0.3,1.5c-0.1,0.3-0.2,0.5-0.3,0.7c-0.8-0.9-2.1-1.2-2.1-1.2L19,24.4l0.2,0.4c0.4,0.9,0.1,1.5-0.3,2.2 c-0.3,0.5-0.5,1.1-0.5,1.7c0,0.9,0.5,1.5,0.9,1.8c-0.3,0.3-0.6,0.7-0.6,1.1c0,0.6,0.3,1.1,0.8,1.3c0.1,0.5,0.4,1.1,0.9,1.4l0,0 L21,44.7c-0.6,0.1-1.1,0.6-1.1,1.3c0,0.7,0.5,1.2,1.2,1.3l0.2,4.3c0,0.3,0.1,0.6,0.3,0.8c0.2,0.2,0.5,0.3,0.8,0.3h0 c0.3,0,0.6-0.1,0.8-0.3c0.2-0.2,0.3-0.5,0.3-0.8l0.2-4.3c0.7,0,1.2-0.6,1.2-1.3c0-0.7-0.5-1.2-1.1-1.3l0.5-10.3h0 c0.5-0.3,0.8-0.8,0.9-1.3c0.1-0.1,0.2-0.1,0.4-0.3c0.3-0.3,0.4-0.6,0.4-1C25.9,31.2,25.6,30.7,25.2,30.5L25.2,30.5z"></path>
</svg></a>
					<a class="site-name" href="<?php echo esc_attr( home_url() ); ?>" rel="home"><?php echo trim( str_replace( 'USC', '', get_bloginfo( 'name' ) ) ); ?></a>
				</div>
				<div class="nav-buttons" aria-label="Navigation and Search">
					<button type="button" class="toggle-0" aria-label="Open Site Navigation / Menu" aria-expanded="false" aria-controls="main-navigation"><?php _e('Menu','pulpfree'); ?></button>
					<button type="button" class="toggle-1" aria-label="Open Site Search" aria-expanded="false" aria-controls="search-form"><?php _e('Search','pulpfree'); ?></button>
				</div>
			</div><!-- .site-branding -->

			<div class="site-nav show-photo">
			<?php
				wp_nav_menu( 
					array(
						'theme_location' => 'main-menu',
						'menu_id' => 'main-navigation',
						'menu_class' => 'primary-menu',
						'container' => false,
					),
				);
			?>
			</div><div class="site-search" id="search-form">
			<?php get_search_form(); ?>
			</div>
			<?php
			
			/* section menu */
			$custom_section = false;
			$custom_section_menu = get_post_meta( get_the_ID(), 'custom_section_menu', true );
			if( $custom_section_menu ) {
				$custom_section = get_post_meta( get_the_ID(), 'choose_section_menu', true );
			}
			
			$menuobject = wp_get_nav_menu_items('Main Menu');
			$GLOBALS['submenu'] = false;
			foreach($menuobject as $item) {
				if( isset( $item->menu_item_parent ) ) {
					if( 0 == intval( $item->menu_item_parent ) ) {
						$current_submenu = $item;
					}
				}

				if( ( is_page( $item->object_id ) || $item->object_id == $custom_section ) && ( ! isset( $item->classes ) || ! $item->classes || ! in_array( 'auxiliary', $item->classes ) ) ) {
					$GLOBALS['submenu'] = $current_submenu;
				}

			}

			if( $GLOBALS['submenu'] ) {
				wp_nav_menu( 
					array( 
						'theme_location' => 'main-menu',
						'menu_id' => 'secondary-navigation',
						'menu_class' => 'section-menu hidden',
						'container' => false,
						'walker' => new Submenu_Walker,
					),
				);
			}

			?>
		</header>



		<div id="container">
			<main id="content" role="main">

