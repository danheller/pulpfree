<?php

function pulpfree_set_content_type(){
	return "text/html";
}
add_filter( 'wp_mail_content_type','pulpfree_set_content_type' );	

require_once( WP_PLUGIN_DIR . '/action-scheduler/action-scheduler.php' );

if ( ! function_exists( 'pulpfree_notify_watchers' ) ) {
	function pulpfree_notify_watchers( $post_id ) {

		$args = array(
			'meta_key' => 'watched',
			'meta_value' => $post_id,
			'meta_compare' => 'LIKE',			
		);

		$user_query = new WP_User_Query( $args );

		// User Loop
		if ( ! empty( $user_query->get_results() ) ) {
			global $wpdb;
			$simple_history_contexts_table = $wpdb->prefix . 'simple_history_contexts';
			$history_id = $wpdb->get_var( "SELECT history_id FROM $simple_history_contexts_table WHERE `key` = 'post_id' AND `value` = $post_id ORDER BY history_id DESC LIMIT 1" );
			$updated_by = $wpdb->get_var( "SELECT `value` FROM $simple_history_contexts_table WHERE history_id = $history_id AND `key` = '_user_id'" );
			$revisions  = wp_get_latest_revision_id_and_total_count( $post_id );
//			if( $revisions && is_array( $revisions ) && isset( $revisions['latest_id'] ) ) {
//				$revision_id = $revisions['latest_id'];
	
				foreach ( $user_query->get_results() as $user ) {
					$user_id = $user->ID;
					$watched_json = get_user_meta( intval($user->ID), 'watched', true );
					if( $watched_json && strlen( $watched_json ) ) {
						$watched = json_decode( $watched_json, true );
					}
					
					if( in_array( intval($post_id), $watched ) ) { //  && intval( $updated_by ) != intval( $user_id )
						$update_args = array('post_id'=>intval($post_id),'updater'=>intval($updated_by),'history_id'=>intval($history_id));
	
						$changed = false;
						$updates = array();
						$updates_json = get_user_meta( intval($user->ID), 'updates', true );
	
						if( $updates_json && strlen( $updates_json ) ) {
							$updates = json_decode( $updates_json, true );
						}
						if( ! count( $updates ) || ! isset( $updates[ $post_id ] ) ) {
							$updates[$post_id] = $update_args;
							$changed = true;
						}
	
						if( $changed ) {
							update_user_meta( $user->ID, 'updates', json_encode( $updates ) );
							as_schedule_single_action( strtotime('+120 seconds'), 'send_update_message' );
						}
					}
				}
//			}
		}
	}
}

add_action( 'wp_after_insert_post', 'pulpfree_notify_watchers' );

add_action( 'send_update_message', 'pulpfree_send_update_message', 10 );
if ( ! function_exists( 'pulpfree_send_update_message' ) ) {
	function pulpfree_send_update_message() {
		$args = array(
			'meta_key' => 'updates',
			'meta_compare' => 'EXISTS',			
		);
	
		$user_query = new WP_User_Query( $args );
	
		foreach ( $user_query->get_results() as $user ) {
			$user_id = $user->ID;
			$email   = $user->user_email;
			$updates = array();
			$updates_json = get_user_meta( intval($user->ID), 'updates', true );
	
			$message = '';
	
			if( $updates_json && strlen( $updates_json ) ) {
				$updates = json_decode( $updates_json, true );
			}
			
			foreach( $updates as $uk => $update ) {
				$post_id = $update['post_id'];
				$updater = get_user_by( 'id', intval($update['updater']) );
				$history_id = $update['history_id'];
				$message .= '<p style="font-size: 18px;">The page <a href="'.get_permalink($post_id).'">'.get_the_title( $post_id ).'</a> was just updated by '.$updater->display_name.' ('.$updater->user_email.'). <a href="'.get_bloginfo('wpurl').'/wp-admin/index.php?page=simple_history_page#item/'.$history_id.'" style="white-space: nowrap; color: #fff; margin: 1rem 0 0;background: #900;display: inline-block; padding: .75rem;border-radius: .25rem; font-weight: 700; font-size: 14px; text-decoration: none;">See what changed</a></p>';
				$subject = 'Updated: '.get_the_title( $post_id );
				if( 'Home' == get_the_title( $post_id ) ) {
					$subject = 'Updated: '.get_bloginfo('name').' homepage';
				}
			}
	
			delete_user_meta( $user->ID, 'updates' );
	
			$message .= '<p style="font-size: 18px;">To stop watching and no longer receive these emails, <a href="'.get_bloginfo('wpurl').'/wp-admin/">sign in to Wordpress</a> then open the page, click the gear (⚙) icon in the lower left corner of the screen, and click the "Update notifications on" link, which will toggle notifications off.</p>';
			if( count( $updates ) > 1 ) {
				$subject = count( $updates ) . ' updates to the ' . get_bloginfo('name') . ' website';
			}
	
			wp_mail(
				$email,
				$subject,
				pulpfree_html_email( $message )
			);
		}
	}
}

if ( ! function_exists( 'pulpfree_html_email' ) ) {

	function pulpfree_html_email( $message, $background = '#f4f4f4' ) {
		$sitename = get_bloginfo( 'name' );
		if( 'USC ' == substr( $sitename, 0, 4 ) ) {
			$sitename = '<img class="usc-logo" src="' . get_template_directory_uri() . '/images/usc-logo.svg" width="150" style="vertical-align: middle;margin: 0 1rem .5rem 0;padding: 0 1rem 0 0;border-right: 1px solid rgba(0,0,0,0.5);" alt="USC">' . substr( $sitename, 4 );
		}
	
		$output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta name="viewport" content="width=device-width"/>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
				<meta name="color-scheme" content="light dark">
				<meta name="supported-color-schemes" content="light dark">
				<style type="text/css">
				table.request { width: 100%; padding: 10px; background: #fff; border-left: 4px solid #ddd; font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: normal; line-height: 1.6; margin: 20px 0; }
				table.request th { width: 150px; vertical-align: top; }
				table.request th, table.request td { padding: 4px; font-size: 16px; }
				div.pending table.request, div.approval table.request { /*background: #f8f3df;*/ border-left-color: #fc0; }
				/*div.processing table.request { /*background: #d4e2f1;*/ border-left-color: #165ca3; }*/
				div.completed table.request { /*background: #dcf3d1;*/ border-left-color: #3fa30d; }
				body, p, table, td, th { font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; }
				@media (prefers-color-scheme: dark ) {body { background-color:#000 !important;} .dark-img { display:block !important; width: auto !important; overflow: visible !important; float: none !important; max-height:inherit !important; max-width:inherit !important; line-height: auto !important; margin-top:0px !important; visibility:inherit !important; } .light-img { display:none; display:none !important; } .darkmode { background-color: #900 !important; } }[data-ogsc] .dark-img { display:block !important; width: auto !important; overflow: visible !important; float: none !important; max-height:inherit !important; max-width:inherit !important; line-height: auto !important; margin-top:0px !important; visibility:inherit !important; }[data-ogsc] .light-img { display:none; display:none !important; }[data-ogsc] .darkmode { background-color: #900 !important; }</style>
			</head>
			<body bgcolor="' . $background . '" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="margin: 0; padding: 0; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; height: 100%; width: 100%!important;">
			<table class="head-wrap" style="width: 100%;">
				<tbody>
					<tr>
						<td class="header container" style="margin: 0 auto!important; padding: 0; clear: both!important; display: block!important; max-width: 600px!important;">
							<div class="content" style="margin: 0 auto; padding: 0; display: block; max-width: 600px; margin-top: 20px!important;">
								<table style="margin: 0; padding: 0; width: 100%;">
									<tbody style="margin: 0; padding: 0;">
										<tr style="margin: 0; padding: 0;">
											<td style="margin: 0; padding: 0;">
												<h2 style="margin:0;padding:0 15px;font-size: 1.875rem; font-weight: 300;"><a href="' . home_url() . '" style="margin: 0; padding: 0; color: #000; text-decoration: none; ">
													'. $sitename .'
												</a></h2>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="body-wrap" style="margin: 0; padding: 0; width: 100%;">
				<tbody>
					<tr style="margin: 0; padding: 0;">
						<td class="container" style="margin: 0 auto!important; padding: 0; clear: both!important; display: block!important; max-width: 600px!important;">
							<div style="margin: 0; padding: 0;">
								<div class="content" style="margin: 0 auto; padding: 15px; display: block; max-width: 600px; padding-top: 0!important;">
									<table style="margin: 0; padding: 0; width: 100%;">
										<tbody>
											<tr style="margin: 0; padding: 0;">
												<td style="margin: 0; padding: 0; padding-top: 0!important;">
													' . $message . '
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</body>
		</html>';
		return $output;	
	}
}
