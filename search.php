<?php
	$bodyclass = 'archive';
	
	get_header();
	if ( have_posts() ) {
	?>
		<header class="page-header">
			<h1 class="entry-title" itemprop="name"><?php echo esc_html__( 'Search Results', 'pulpfree' ); ?></h1>

			<form class="search-again" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
				<label for="search-again-query"><?php echo esc_html__( 'Search', 'pulpfree' ); ?></label>
				<input type="text" id="search-again-query" class="search-field" name="s" title="search" placeholder="Search <?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" /><button type="submit" class="search-submit">search</button>
				<div class="sort">
					<label for="sort"><?php _e('Sort by','pulpfree'); ?></label>
					<select name="orderby" id="sort">
						<option value="relevance"><?php _e('Relevance','pulpfree'); ?></option>
						<option value="new"<?php if( isset( $_GET['orderby'] ) && 'date' == $_GET['orderby'] && isset( $_GET['order'] ) && 'desc' == $_GET['order'] ) { echo ' selected="selected"'; } ?>><?php _e('Newest','pulpfree'); ?></option>
						<option value="old"<?php if( isset( $_GET['orderby'] ) && 'date' == $_GET['orderby'] && isset( $_GET['order'] ) && 'asc' == $_GET['order'] ) { echo ' selected="selected"'; } ?>><?php _e('Oldest','pulpfree'); ?></option>
					</select>
				</div>
				<p class="summary"><?php 
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$first_result = ( ( $paged - 1 ) * $wp_query->query_vars['posts_per_page'] ) + 1;
					$last_result = $first_result + $wp_query->post_count - 1;
					echo $first_result . ' – ' . $last_result . ' ' . __( 'of ','pulpfree') . $wp_query->found_posts . ' ';
					if( 1 == $wp_query->found_posts ) {
						_e( 'search result for ','pulpfree');					
					} else {
						_e( 'search results for ','pulpfree');
					}
					echo '<strong>' . esc_html( get_search_query() ) . '</strong>';
				?></p>
			</form>
		</header>
		<div class="entry-content" itemprop="mainContentOfPage">
	<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'entry' );
		}
		get_template_part( 'nav', 'below' ); 
	?>
		</div>
	<?php
	} else { ?>
		<article id="post-0" class="post no-results not-found">
			<header class="page-header">
				<h1 class="entry-title" itemprop="name"><?php esc_html_e( 'Nothing Found', 'pulpfree' ); ?></h1>
			</header>
			<div class="entry-content" itemprop="mainContentOfPage">
				<p><?php esc_html_e( 'Sorry, nothing matched your search. Please try again.', 'pulpfree' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</article>
<?php
	}
	get_footer();
