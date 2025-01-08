<?php
/**
 * Processes AJAX requests
 *
 * @package pulpfree
 */

add_action( 'wp_ajax_watch_post', 'watch_post' );
add_action( 'wp_ajax_nopriv_watch_post', 'watch_post' );
add_action( 'wp_ajax_update_post_setting', 'update_post_setting' );
add_action( 'wp_ajax_nopriv_update_post_setting', 'update_post_setting' );


/**
 * Watch (or unwatch) a post
 */
 
function watch_post() {
	check_ajax_referer( 'pulpfree-settings' );

	$fields = array('id','watch');
	foreach( $fields as $f ) {
		if( isset( $_POST[ $f ] ) ) {
			$data[ $f ] = $_POST[ $f ];
		}
	}
	$post_id = $data[ 'id' ];
	$user = wp_get_current_user();
	if( isset( $user->ID ) ) {
		$changed = false;
		$message = 'unchanged';
		$watched = array();
		$watched_json = get_user_meta( intval($user->ID), 'watched', true );
		if( $watched_json && strlen( $watched_json ) ) {
			$watched = json_decode( $watched_json, true );
		}
		if( ( ! count( $watched ) || ! in_array( $post_id, $watched ) ) && $data['watch'] ) {
			$watched[] = intval($post_id);
			$changed = true;
		} else if( in_array( $post_id, $watched ) && ( ! isset( $data['watch'] ) || ! $data['watch'] ) ) {
			$key = array_search($post_id, $watched);
			unset( $watched[ $key ] );
			$changed = true;
		}
		if( $changed ) {
			update_user_meta( $user->ID, 'watched', json_encode( $watched ) );	
			$message = 'changed';
		}
		echo 'Post ' . $post_id . ', user ' . $user->ID . ', ' . $message;
	}
	die();
}

/**
 * Update a post setting
 */
 
function update_post_setting() {
	check_ajax_referer( 'pulpfree-settings' );

	$fields = array('id','field','value');
	foreach( $fields as $f ) {
		if( isset( $_POST[ $f ] ) ) {
			$data[ $f ] = $_POST[ $f ];
			if( 'false' == $_POST[ $f ] ) {
				$data[ $f ] = false;
			}
		}
	}
	update_post_meta( $data['id'], $data['field'], $data['value'] );	
	die();
}