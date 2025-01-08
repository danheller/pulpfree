<div class="entry-summary">
	<div itemprop="description"><p><?php echo wp_trim_words( wp_strip_all_tags( get_the_excerpt( get_the_ID() ) ), 40, '...' ); ?></p></div>
	<?php 
		if( 'post' == get_post_type() ) {
	?>
	<time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" title="<?php echo esc_attr( get_the_date() ); ?>" <?php if ( is_single() ) { echo 'itemprop="datePublished" pubdate'; } ?>><?php the_time( get_option( 'date_format' ) ); ?></time>
<?php 
		}
	if ( is_search() ) {
?>
	<div class="entry-links"><?php wp_link_pages(); ?></div>
<?php
	}
?>
</div>