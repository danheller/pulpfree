<?php
	$related_articles = $related_cats = false;
	$GLOBALS['related'] = $post->ID;
	if( get_post_meta($post->ID,'related_articles', true) ) { 
		$related_articles = get_post_meta($post->ID,'related_articles', true);
	}

	if( has_category() ) {
		$related_cats = wp_get_post_terms( $post->ID, 'category', array( 'fields' => 'ids' ) );
	}

	if( $related_articles || $related_cats ) {
		$articles = array();

		/* first, try for 3 articles in the related articles field */
		if($related_articles) { 
			foreach($related_articles as $article_id) {
				if( $GLOBALS['related'] != $article_id && ! in_array($article_id,$articles) ) {
					$articles[] = $article_id;
				}
			}
		}

		/* if less than 3 related articles, try for articles with related categories */			
		if( $related_cats && count( $articles ) < 3 ) { 
			$args = array( 'ignore_sticky_posts' => true, 'fields' => 'ids' );
			$args['category__in'] = $related_cats;
			$relateds = new WP_Query($args);
			if( $relateds->have_posts() ) {
				foreach($relateds->posts as $article_id) {
					if( $GLOBALS['related'] != $article_id && ! in_array($article_id,$articles)) {
						$articles[] = $article_id;
					}
				}
			}
		}

		if($articles) { 
			$articles = array_slice( $articles, 0, 3 );
			?>
			<div class="related">
			<h2><?php _e('Related Articles', 'pulpfree'); ?></h2>
			<?php
			foreach( $articles as $article_id ) {
				$args    = array( 'p' => $article_id );
				$article = new WP_Query($args);
				if ( $article->have_posts() ) {
					while ( $article->have_posts() ) {
						$article->the_post();
						get_template_part( 'entry' );
					}
				}
			}
			if( $related_cats ) {
				$cat_slug = get_term_field( 'slug', $related_cats[0], 'category' );
				echo '<a class="more" href="/category/'. $cat_slug . '">More Stories</a>';
			}
			
			?>
			</div>
			<?php
			
		}
	}
	$GLOBALS['related'] = false;
	wp_reset_query();
