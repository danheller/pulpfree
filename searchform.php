<form role="search" method="get" action="<?php echo home_url( '/' ); ?>"><h2><?php _e('What are you looking for?','pulpfree'); ?></h2><label for="search-query" class="screen-reader-text"><?php echo  esc_html( __('Search ','pulpfree') . get_bloginfo( 'name' ) ); ?></label><input type="text" id="search-query" class="search-field" name="s" title="search" placeholder="<?php echo esc_attr( __('Search ','pulpfree') . get_bloginfo( 'name' ) ); ?>" /><button type="submit" class="search-submit"><?php _e('search','pulpfree'); ?></button>

<?php 
	// suggested search keywords
	$suggested = get_option('suggested_searches');
	if( isset( $suggested ) && strlen( trim( $suggested ) ) ) {
		$suggested = explode("\n", $suggested);
		if ( count( $suggested ) ) {
			echo '<div class="suggestions"><h3>' . __('Suggested Searches','pulpfree') . '</h3><ul>';
			foreach( $suggested as $sug ) {
				if( trim( $sug ) ) {
					echo '<li><a href="' . home_url() . '/?s=' . urlencode( esc_attr( strtolower( wp_strip_all_tags( $sug ) ) ) ) . '">' . $sug . '</a></li>';
				}
			}
			echo '</ul></div>';
		}
	}
?>
</form>
