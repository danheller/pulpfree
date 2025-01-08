<?php

$shown_options = array(
	'transparent',
	'top_shadow',
	'bottom_shadow',
);


$group_id = 2610;
if( "localhost" != $_SERVER['HTTP_HOST'] ) {
	$group_id = 'acf_post_and_page_settings';
}

if (function_exists('acf_get_field_groups')) {
	$acf_post_settings = acf_get_fields( $group_id );

	foreach( $acf_post_settings as $key => $aps ) {
		if( isset( $aps['name'] ) && $aps['name'] && in_array( $aps['name'], $shown_options ) ) {
			$acf_post_settings[ $key ]['shown'] = true;
		} else {
			$acf_post_settings[ $key ]['shown'] = false;		
		}
	}
}

?>
<div class="customizer">
	<button class="toggle-panel"><?php echo __("Customize","pulpfree") . ' ' . ucwords( $post->post_type ); ?></button>

	<div class="panel">
		<button class="close" type="button">
			<?php _e('Close panel'); ?>
		</button>

		<h3><?php echo ucwords( $post->post_type ) . ' ' . __("Settings","pulpfree"); ?></h3>
		<?php

			foreach( $acf_post_settings as $setting ) {
				if( isset( $setting['shown'] ) && $setting['shown'] ) {

					$current_setting = get_post_meta( get_the_ID(), $setting['name'], true );
					echo '<div class="setting">';
					if( 'true_false' == $setting['type'] ) {
						echo '<input type="checkbox" id="' . $setting['name'] . '" name="' . $setting['name'] . '"';
						if( $current_setting ) {
							echo ' checked="checked"';
						}
						echo '>';
					}
					echo '<label for="' . $setting['name'] . '">' . $setting['label'] . '</label>';

					if( 'select' == $setting['type'] ) {
						echo '<div class="select-container"><select id="' . $setting['name'] . '" name="' . $setting['name'] . '">';
						foreach( $setting['choices'] as $chk => $choice ) {
							echo '<option value="' . $chk . '"';
							if( $current_setting == $chk ) {
								echo ' selected="selected"';
							}
							echo '>' . $choice . '</option>';
						}
						echo '</select></div>';
					}
					echo '</div>';
				}
			}

			if( current_user_can( 'edit_posts' ) && is_singular() ) {
				wp_enqueue_script('alumni_admin');
				wp_reset_query();
				$status = '';
				$message = 'Watch this page';
			
				$user = wp_get_current_user();
				if( isset( $user->ID ) ) {
					$watched_json = get_user_meta( intval($user->ID), 'watched', true );
					if( $watched_json ) {
						$watched = json_decode( $watched_json, true );
						if( in_array( get_the_ID(), $watched ) ) {
							$status = ' checked';
							$message = 'Update notifications on';
						}
					}
				}
				echo '<script type="text/javascript">nonce = "' . wp_create_nonce( 'pulpfree-settings' ) . '";post_id = ' . get_the_ID() . ';ajax  = "' . esc_url( admin_url( 'admin-ajax.php' ) ) . '";</script>';
				echo '<button class="watch'.$status.'" type="button">'.$message.'</button>';
			}

			echo '<button class="edit" type="button">' . __('Edit this ') . $post->post_type . '</button>';


/*
			echo '<textarea style="clear:both;margin:2rem;">';
			print_r( $acf_post_settings );
			echo '</textarea>';
*/
		?>
	</div>
</div>