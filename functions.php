<?php
/**
 * Functions and definitions
 *
 * @package pulpfree
 *
 * Table of Contents
 * 1.0	Theme Setup
 * 2.0	Wordpress Editor
 * 3.0	Header
 * 3.1	Cascading Style Sheets (CSS) and Javascript (JS)
 * 4.0	Navigation
 * 4.1	Menus
 * 4.2	Pagination
 * 5.0	Content
 * 5.1	Style Picker Options
 * 5.2	Excerpt
 * 5.3	Pings and Comments
 * 6.0	Media
 * 6.1	Images
 * 7.0 	Footer
 * 8.0	Advanced Custom Fields
 * 8.1	Blocks
 * 9.0	Customizations
 * 9.1	Suggested Searches
 * 9.2	Menu Photo
 * 10.0	Admin AJAX
 * 11.0	Scheduled Actions
 */


/*--------------------------------------------------------------
 * 1.0	Theme Setup
 *------------------------------------------------------------*/

	$GLOBALS['version'] = 2024112401; // set version number to increment css, js, etc.

	/**
	 * Theme features
	 */
	function pulpfree_setup() {
		load_theme_textdomain( 'pulpfree', get_template_directory() . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'search-form', 'navigation-widgets' ) );
		add_theme_support( 'appearance-tools' );
		add_theme_support( 'wp-block-styles' ); // Load default block styles.

		global $content_width;
		if ( !isset( $content_width ) ) {
			$content_width = 1920;
		}

		$menus = array( 'Main', 'Footer', 'Audience', 'Compliance', 'Utility' );
		foreach( $menus as $menu ) {
			register_nav_menus( array( strtolower( $menu ) . '-menu' => esc_html__( $menu . ' Menu', 'pulpfree' ) ) );
		}
	}
	add_action( 'after_setup_theme', 'pulpfree_setup' );



/*--------------------------------------------------------------
 * 2.0	Wordpress Editor
 *------------------------------------------------------------*/

	/**
	 * Custom fonts for editor
	 */
	function pulpfree_fonts_url() {
		$fonts_url = '';
		$font_families = array();
		$font_families[] = 'Source Sans 3:300,300i,500,500i,700,700i';
		$query_args = array(
			'family'  => urlencode( implode( '|', $font_families ) ),
			'subset'  => urlencode( 'latin,latin-ext' ),
			'display' => urlencode( 'fallback' ),
		);
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		return esc_url_raw( $fonts_url );
	}
	add_editor_style( array( 'css/_editor-styles.css', pulpfree_fonts_url() ) );


	// Load regular editor styles into the new block-based editor.
	add_theme_support( 'editor-styles' );

	// Load default block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	function pulpfree_block_editor_styles() {
		// Block styles.
		wp_enqueue_style( 'pulpfree-block-editor-style', get_theme_file_uri( '/css/editor-blocks.css' ), array(), $GLOBALS['version'] );
		// Add custom fonts.
		wp_enqueue_style( 'pulpfree-fonts', pulpfree_fonts_url(), array(), null );
	}
	add_action( 'enqueue_block_editor_assets', 'pulpfree_block_editor_styles' );



/*--------------------------------------------------------------
 * 3.0 	Header
 *------------------------------------------------------------*/


	/**
	* Enable the HTTP Strict Transport Security (HSTS) header in WordPress.
	*/
	
	function pulpfree_enable_strict_transport_security_hsts_header_wordpress() {
		header( 'Strict-Transport-Security: max-age=31536000' );
	}
	add_action( 'send_headers', 'pulpfree_enable_strict_transport_security_hsts_header_wordpress' );

	function pulpfree_schema_type() {
		$schema = 'https://schema.org/';
		if ( is_single() ) {
			$type = "Article";
		} elseif ( is_author() ) {
			$type = 'ProfilePage';
		} elseif ( is_search() ) {
			$type = 'SearchResultsPage';
		} else {
			$type = 'WebPage';
		}
		echo 'itemscope itemtype="' . esc_url( $schema ) . esc_attr( $type ) . '"';
	}

	add_filter( 'nav_menu_link_attributes', 'pulpfree_schema_url', 10 );
	function pulpfree_schema_url( $atts ) {
		$atts['itemprop'] = 'url';
		return $atts;
	}

	add_action( 'wp_head', 'pulpfree_pingback_header' );
	function pulpfree_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

/*--------------------------------------------------------------
 * 3.1 	Cascading Style Sheets (CSS) and Javascript (JS)
 *------------------------------------------------------------*/

	if( ! is_admin() ) {
		function pulpfree_enqueue() {
			// site-specific css
			wp_enqueue_style( 'pulpfree-style', get_bloginfo('template_directory') . '/css/style.css', false, $GLOBALS['version'], 'screen,print'  ); // $handle, $src, $deps, $ver, $media

			//site-specific js
			wp_enqueue_script( 'pulpfree-scripts', get_bloginfo('template_directory') . '/js/scripts.min.js', false, $GLOBALS['version'], 1 );

			// admin css and js
			if( current_user_can( 'edit_posts' ) ) {
				wp_enqueue_style( 'admin-style', get_bloginfo('template_directory') . '/css/admin.css', false, $GLOBALS['version'], 'screen,print'  );
				wp_enqueue_script( 'admin-scripts', get_bloginfo('template_directory') . '/js/admin.js', false, $GLOBALS['version'], 1 );
			}

		}
		add_action( 'wp_enqueue_scripts', 'pulpfree_enqueue' );
	}


/*--------------------------------------------------------------
 * 4.0	Navigation
 *------------------------------------------------------------*/

/*--------------------------------------------------------------
 * 4.1	Menus
 *------------------------------------------------------------*/

	/**
	 * Menus are defined in the pulpfree_setup function under the "1.0 Theme Setup" section
	 */
	 
	/**
	 * Section menu field choices
	 * This field allows pages that aren't in the site menu to show a section menu
	 */
	function section_menu_choices( $field ) {
		// reset choices
		if( 'choose_section_menu' == $field['name'] ) {
			$field['choices'] = array(0 => '');
	
			$args = array( 'post_status' => 'publish', 'post_type' => 'page', 'orderby' => 'title', 'order' => 'ASC', 'post_parent' => 0, 'posts_per_page'=>-1 );	
			$pages = new WP_Query($args);
			foreach($pages->posts as $p) {
				$slug = $p->post_name;
				$field['choices'][$p->ID] = $p->post_title;
			}
		}
		return $field;
	}	
	add_filter('acf/load_field/name=choose_section_menu', 'section_menu_choices', 10, 3);

	/**
	 * Determine the top level ancestor of a page.
	 */
	function is_tree( $pid ) {      // $pid = The ID of the page we're looking for pages underneath
		global $post;               // load details about this page

		if ( is_page($pid) ) {
			return true;            // we're at the page or at a sub page
		}

		$anc = get_post_ancestors( $post->ID );
		foreach ( $anc as $ancestor ) {
			if( is_page() && $ancestor == $pid ) {
				return true;
			}
		}
		return false;  // we aren't at the page, and the page is not an ancestor
	}

	/**
	 * Create HTML list of nav menu items.
	 * Replacement for the native Walker, using the description.
	 *
	 * @see    http://wordpress.stackexchange.com/q/14037/
	 * @author toscho, http://toscho.de
	 * 
	 * usage: wp_nav_menu( array( 'walker' => new Description_Walker ));
	 */
	
	class Submenu_Walker extends Walker_Nav_Menu {
		function start_el( &$output, $data_object, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$class_names = $value = '';
			
			$classes = empty( $data_object->classes ) ? array() : (array) $data_object->classes;
			$classes[] = 'menu-item-' . $data_object->ID;
	
			if( $data_object->menu_item_parent == 0 ) {
				$GLOBALS['current'] = false;
				if ( $GLOBALS['submenu']->ID == $data_object->ID ) {
					$GLOBALS['current'] = true;
				}
			}
			
			if( $GLOBALS['current'] ) {
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $data_object, $args ) );
				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		
				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $data_object->ID, $data_object, $args );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		
				$output .= "<li id='menu-item-$data_object->ID' $class_names>";
				$attributes  = '';
		
				$attributes  = ! empty( $data_object->attr_title ) ? ' title="'  . esc_attr( $data_object->attr_title ) .'"' : '';
				$attributes .= ! empty( $data_object->target )     ? ' target="' . esc_attr( $data_object->target     ) .'"' : '';
				$attributes .= ! empty( $data_object->xfn )        ? ' rel="'    . esc_attr( $data_object->xfn        ) .'"' : '';
				$attributes .= ! empty( $data_object->url )        ? ' href="'   . esc_attr( $data_object->url        ) .'"' : '';
		
				$data_object_output = $args->before
				. "<a $attributes>"
				. $args->link_before
				. apply_filters( 'the_title', $data_object->title, $data_object->ID )
				. $args->link_after
				. '</a>'
				. $args->after;
		
				$output .= apply_filters( 'walker_nav_menu_start_el', $data_object_output, $data_object, $depth, $args );
			}
		}

		public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
			if( $GLOBALS['current'] ) {
				if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
					$t = '';
					$n = '';
				} else {
					$t = "\t";
					$n = "\n";
				}
				$output .= "</li>{$n}";
			}
		}
	
		function start_lvl( &$output, $depth = 0, $args = null ) {
			if( $GLOBALS['current'] ) {
				if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
					$t = '';
					$n = '';
				} else {
					$t = "\t";
					$n = "\n";
				}
				$indent = str_repeat( $t, $depth );
			
				// Default class.
				$classes = array( 'sub-menu' );
			
				/**
				 * Filters the CSS class(es) applied to a menu list element.
				 *
				 * @since 4.8.0
				 *
				 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
				 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
				 * @param int      $depth   Depth of menu item. Used for padding.
				 */
				$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			
				$atts          = array();
				$atts['class'] = ! empty( $class_names ) ? $class_names : '';
			
				/**
				 * Filters the HTML attributes applied to a menu list element.
				 *
				 * @since 6.3.0
				 *
				 * @param array $atts {
				 *     The HTML attributes applied to the `<ul>` element, empty strings are ignored.
				 *
				 *     @type string $class    HTML CSS class attribute.
				 * }
				 * @param stdClass $args      An object of `wp_nav_menu()` arguments.
				 * @param int      $depth     Depth of menu item. Used for padding.
				 */
				$atts       = apply_filters( 'nav_menu_submenu_attributes', $atts, $args, $depth );
				$attributes = $this->build_atts( $atts );
			
				$output .= "{$n}{$indent}<ul{$attributes}>{$n}";
			}
		}
	
		function end_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent  = str_repeat( $t, $depth );
			if( $GLOBALS['current'] ) {
				$output .= "$indent</ul>{$n}";
			}
		}
	}


/*--------------------------------------------------------------
 * 4.2	Pagination
 *------------------------------------------------------------*/


	function pulpfree_numeric_pagination() {
	  
		if( is_singular() )
			return;
		
		global $wp_query;
		
		/** Stop execution if there's only 1 page */
		if( $wp_query->max_num_pages <= 1 )
			return;
		
		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$max   = intval( $wp_query->max_num_pages );
		
		/** Add current page to the array */
		if ( $paged >= 1 )
			$links[] = $paged;
		
		/** Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
			$links[] = $paged - 3;
		}
		
		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 3;
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}
		
		foreach( $links as $lk => $ln ) {
			if( $ln < 1 || $ln > $max ) {
				unset( $links[$lk] );
			}
		}
		
		echo '<div class="pagination"><ul>' . "\n";
		
		/** Previous Post Link */
		if ( get_previous_posts_link() )
			echo str_replace( array( '>Previous', '</a' ), array( ' title="Go to previous page" rel="prev"><span class="visually-hidden">Previous', '</span></a' ), sprintf( '<li class="previous">%s</li>' . "\n", get_previous_posts_link('Previous page') ) );
		
		/** Link to first page, plus ellipses if necessary */
		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="active"' : '';
		
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
		
			if ( ! in_array( 2, $links ) )
				echo '<li> class="ellipsis"><span>…</span></li>';
		}
		
		/** Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
		}
		
		/** Link to last page, plus ellipses if necessary */
		if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) )
				echo '<li class="ellipsis"><span>…</span></li>' . "\n";
		
			$class = $paged == $max ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		}
		
		/** Next Post Link */
		if ( get_next_posts_link() )
			echo str_replace( array('>Next','</a'), array(' title="Go to next page" rel="next"><span class="visually-hidden">Next','</span></a'), sprintf( '<li class="next">%s</li>' . "\n", get_next_posts_link('Next page') ) );
	
		
		echo '</ul></div>' . "\n";
	  
	}



/*--------------------------------------------------------------
 * 5.0	Content
 *------------------------------------------------------------*/


	/**
	 * Skip link
	 */
	add_action( 'wp_body_open', 'pulpfree_skip_link', 5 );
	function pulpfree_skip_link() {
		echo '<div role="region" aria-label="Skip to content"><a href="#content" class="skip-link screen-reader-text" aria-label="Skip to the content">' . esc_html__( 'Skip to the content', 'pulpfree' ) . '<div class="content" aria-hidden="true"><span class="icon">↵</span>ENTER</div></a></div>';
	}

	/**
	 * Read more link
	 */
	add_filter( 'the_content_more_link', 'pulpfree_read_more_link' );
	function pulpfree_read_more_link() {
		if ( !is_admin() ) {
			return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'pulpfree' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
		}
	}
	
	if ( !function_exists( 'pulpfree_wp_body_open' ) ) {
		function pulpfree_wp_body_open() {
			do_action( 'wp_body_open' );
		}
	}

	/**
	 * Substitute ellipsis if title is empty
	 */
	function pulpfree_title( $title ) {
		if ( $title == '' ) {
			return esc_html( '...' );
		} else {
			return wp_kses_post( $title );
		}
	}
	add_filter( 'the_title', 'pulpfree_title' );



/*--------------------------------------------------------------
 * 5.1	Style Picker Options
 *------------------------------------------------------------*/

	 
	register_block_style('core/paragraph', [
		'name' => 'introduction',
		'label' => 'Introduction'
	]);

	register_block_style('core/paragraph', [
		'name' => 'alert',
		'label' => 'Alert'
	]);

	register_block_style('core/paragraph', [
		'name' => 'note',
		'label' => 'Note'
	]);

	register_block_style('core/media-text', [
		'name' => 'wide-image',
		'label' => '2/3-Width Image'
	]);

	register_block_style('core/media-text', [
		'name' => 'full-width-image',
		'label' => 'Full Width'
	]);
	
	register_block_style('core/media-text', [
		'name' => 'full-width-cta',
		'label' => 'Call To Action'
	]);	
	


/*--------------------------------------------------------------
 * 5.2	Excerpts
 *------------------------------------------------------------*/


	add_filter( 'excerpt_more', 'pulpfree_excerpt_read_more_link' );
	function pulpfree_excerpt_read_more_link( $more ) {
		if ( !is_admin() ) {
			global $post;
			if( isset( $post ) && isset( $post->ID ) ) {
				return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'pulpfree' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
			}
		}
	}


/*--------------------------------------------------------------
 * 5.3	Pings and Comments
 *------------------------------------------------------------*/


	add_action( 'comment_form_before', 'pulpfree_enqueue_comment_reply_script' );
	function pulpfree_enqueue_comment_reply_script() {
		if ( get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	function pulpfree_custom_pings( $comment ) {
	?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
	<?php
	}
	
	add_filter( 'get_comments_number', 'pulpfree_comment_count', 0 );
	function pulpfree_comment_count( $count ) {
		if ( !is_admin() ) {
			global $id;
			$get_comments = get_comments( 'status=approve&post_id=' . $id );
			$comments_by_type = separate_comments( $get_comments );
			return count( $comments_by_type['comment'] );
		} else {
			return $count;
		}
	}


/*--------------------------------------------------------------
 * 6.0	Media
 *------------------------------------------------------------*/

/*--------------------------------------------------------------
 * 6.1	Images
 *------------------------------------------------------------*/

	/**
	 * Resize images dynamically
	 */

	if ( ! function_exists( 'pulpfree_image_resize' ) ) {
		function pulpfree_image_resize( $attachment_id, $width, $height, $crop = true ) {
			$path = get_attached_file( $attachment_id );
			if ( ! file_exists( $path ) ) {
				return false;
			}
		
			$upload    = wp_upload_dir();
			$path_info = pathinfo( $path );
			$base_url  = $upload['baseurl'] . str_replace( $upload['basedir'], '', $path_info['dirname'] );
		
			$meta = wp_get_attachment_metadata( $attachment_id );
			foreach ( $meta['sizes'] as $key => $size ) {
				if ( $size['width'] == $width && $size['height'] == $height ) {
					return "{$base_url}/{$size['file']}";
				}
			}
		
			// Generate new size
			$resized = image_make_intermediate_size( $path, $width, $height, $crop );
			if ( $resized && ! is_wp_error( $resized ) ) {
				// Let metadata know about our new size.
				$key                 = sprintf( 'resized-%dx%d', $width, $height );
				$meta['sizes'][$key] = $resized;
				wp_update_attachment_metadata( $attachment_id, $meta );
				return "{$base_url}/{$resized['file']}";
			}
		
			// Return original if fails
			return "{$base_url}/{$path_info['basename']}";
		}
	}

	/**
	 * Remove extra image sizes
	 */

	add_filter( 'big_image_size_threshold', '__return_false' );
	add_filter( 'intermediate_image_sizes_advanced', 'pulpfree_image_insert_override' );
	function pulpfree_image_insert_override( $sizes ) {
		unset( $sizes['large'] );
		unset( $sizes['medium'] );
		unset( $sizes['medium_large'] );
		unset( $sizes['1536x1536'] );
		unset( $sizes['2048x2048'] );
		return $sizes;
	}

	/**
	 * Choose the appropriate image version for large-format usage
	 */

	if ( ! function_exists( 'pulpfree_wide_image' ) ) {
		function pulpfree_wide_image( $attachment_id, $attributes = array() ) { // check width of full-size image
			$output = '';
			$image_meta = wp_get_attachment_metadata( $attachment_id );
			$image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
			$thumbnail_width = $image_meta['width'];
			$thumbnail_height = $image_meta['height'];
			if(!$thumbnail_width) { $thumbnail_width = $image_meta['sizes']['full']['width']; }			
			if(!$thumbnail_height) { $thumbnail_width = $image_meta['sizes']['full']['height']; }			
			if( $thumbnail_width && $thumbnail_height ) {
				$ratio = $thumbnail_width / $thumbnail_height;
				if( $ratio > 1.5 && $thumbnail_width < 3000 ) {
					$output .= wp_get_attachment_image( $attachment_id, 'full', false, $attributes );
				} else {
					$image_url = pulpfree_image_resize( $attachment_id, 1600, 900 );
					$output .= '<img src="' . $image_url . '" alt="' . $image_alt . '"';
					if( $attributes && is_array( $attributes ) ) {
						foreach( $attributes as $key => $att ) {
							$output .= ' ' . $key . '="' . esc_attr( $att ) . '"';
						}
					}
					$output .= '>';
				}
			} else {
				$image_url = pulpfree_image_resize( $attachment_id, 1600, 900 );
				$output .= '<img src="' . $image_url . '" alt="' . $image_alt . '"';
				if( $attributes && is_array( $attributes ) ) {
					foreach( $attributes as $key => $att ) {
						$output .= ' ' . $key . '="' . esc_attr( $att ) . '"';
					}
				}
				$output .= '>';
			}
			return $output;
		}
	}

/*--------------------------------------------------------------
 * 7.0	Footer
 *------------------------------------------------------------*/


	if (function_exists('register_sidebar')) {
		register_sidebar(array(
			'name' => 'Footer Column 1',
			'id'   => 'footer-column-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'description'   => 'Widget area for the footer',
		));
	
		register_sidebar(array(
			'name' => 'Footer Column 2',
			'id'   => 'footer-column-2',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'description'   => 'Widget area for the footer',
		));
	}



/*--------------------------------------------------------------
 * 8.0	Advanced Custom Fields
 *------------------------------------------------------------*/


	if( "localhost" != $_SERVER['HTTP_HOST'] ) {
		require get_template_directory() . '/functions/acf-groups.php';
	}


/*--------------------------------------------------------------
 * 8.1	Blocks
 *------------------------------------------------------------*/

	/**
	 * Define theme-specific blocks
	 */

	add_action('acf/init', 'pulpfree_custom_acf_blocks');
	function pulpfree_custom_acf_blocks() {
		
		// check function exists
		if( function_exists('acf_register_block') ) {
	
			$pulpfree_acf_blocks = array(
				array(
					'name' => 'acf/article-carousel',
					'title' => 'Article Carousel',
					'description' => 'A slider made of rounded rectangles that contain an image and a headline',
					'category' => 'widgets',
					'icon' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 12" style="enable-background:new 0 0 12 12;" xml:space="preserve"><path d="M3.5,5.6H0v0.6h3.5V5.6z M7.8,5.6H4.3v0.6h3.5V5.6z M12,5.6H8.5v0.6H12V5.6z"/><rect y="1" width="3.5" height="3.9"/><rect x="8.5" y="1" width="3.5" height="3.9"/><rect x="4.3" y="1" width="3.5" height="3.9"/><rect x="-0.1" y="8.5" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.9139 3.3428)" width="2.3" height="0.6"/><rect x="0.8" y="8.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -6.7737 3.704)" width="0.6" height="2.3"/><rect x="4" y="9.8" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.6066 6.6062)" width="2.3" height="0.6"/><rect x="4.9" y="7.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -4.7465 6.2442)" width="0.6" height="2.3"/></svg>', // 'slides',
				),
				array(
					'name' => 'acf/cta-card-collection',
					'title' => 'Call To Action Cards',
					'description' => 'A set of links in rounded rectangles on a shaded background',
					'category' => 'widgets',
					'icon' => 'screenoptions',
				),
				array(
					'name' => 'acf/editorial-cards',
					'title' => 'Editorial Cards',
					'description' => 'Square photos set in three columns over a cardinal background',
					'category' => 'widgets',
					'icon' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 12" style="enable-background:new 0 0 12 12;" xml:space="preserve"><path d="M3.5,4.6H0v0.6h3.5V4.6z M7.8,4.6H4.3v0.6h3.5V4.6z M12,4.6H8.5v0.6H12V4.6z"/><rect width="3.5" height="3.9"/><rect x="8.5" width="3.5" height="3.9"/><rect x="4.3" width="3.5" height="3.9"/><path d="M3.5,11.1H0v0.6h3.5V11.1z M7.8,11.1H4.3v0.6h3.5V11.1z M12,11.1H8.5v0.6H12V11.1z"/><rect y="6.5" width="3.5" height="3.9"/><rect x="8.5" y="6.5" width="3.5" height="3.9"/><rect x="4.3" y="6.5" width="3.5" height="3.9"/></svg>',
				),
				array(
					'name' => 'acf/featured-articles',
					'title' => 'Featured Articles',
					'description' => 'Four posts displayed like news stories',
					'category' => 'widgets',
					'icon' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 12 12"><rect y="1.6" width="7.1" height="3.9"/><rect x="8.5" y="1.6" width="3.5" height="2.2"/><rect x="8.5" y="4.8" width="3.5" height="2.2"/><rect x="8.5" y="8.1" width="3.5" height="2.2"/><path d="M5.9,6.2H0v.6h5.9v-.6ZM7,7.4H0v.6h7v-.6Z"/></svg>',
				),
				array(
					'name' => 'acf/featured-video',
					'title' => 'Featured Video',
					'description' => 'A video with a title and paragraph beside it',
					'category' => 'widgets',
					'icon' => 'video-alt2',
				),
				array(
					'name' => 'acf/full-width-video',
					'title' => 'Full-Width Video',
					'description' => 'A video that fills the full browser width',
					'category' => 'widgets',
					'icon' => 'video-alt2',
				),
				array(
					'name' => 'acf/headline-with-buttons',
					'title' => 'Headline with Buttons',
					'description' => 'A centered headline above outline buttons on a white or gray background',
					'category' => 'widgets',
					'icon' => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 12" style="enable-background:new 0 0 12 12;" xml:space="preserve"><style type="text/css">.st0{fill:#FFFFFF;stroke:#000000;stroke-width:0.25;stroke-linejoin:round;stroke-miterlimit:10;}</style><path d="M1.4,3.3c0-0.4,0-1.2,0-1.3c0-0.3,0-0.4-0.3-0.4H0.8c0,0,0,0,0,0V1.3c0,0,0,0,0.1,0c0.1,0,0.3,0,0.9,0c0.5,0,0.7,0,0.8,0 c0,0,0.1,0,0.1,0v0.2c0,0,0,0,0,0H2.2C2,1.5,2,1.7,2,1.9C2,2,2,2.8,2,3.2v0.1c0,0,0,0,0.1,0h2.3c0.1,0,0.1,0,0.1-0.1V3.2 c0-0.4,0-1.2,0-1.3c0-0.2,0-0.3-0.2-0.3H4c0,0,0,0,0,0V1.3c0,0,0,0,0,0c0.1,0,0.4,0,0.8,0c0.4,0,0.7,0,0.8,0c0,0,0,0,0,0v0.2 c0,0,0,0,0,0H5.3c-0.2,0-0.2,0.1-0.2,0.3c0,0.1,0,1.1,0,1.4v0.2c0,0.2,0,1.4,0,1.8c0,0.2,0.1,0.3,0.3,0.3h0.3c0,0,0.1,0,0.1,0v0.2 c0,0,0,0,0,0c-0.1,0-0.3,0-0.8,0c-0.5,0-0.7,0-0.9,0c0,0,0,0,0,0V5.6c0,0,0,0,0.1,0h0.4c0.2,0,0.2-0.1,0.2-0.3c0-0.3,0-1.3,0-1.5 V3.6c0-0.1,0-0.1-0.1-0.1H2.1C2,3.6,2,3.6,2,3.6v0.1c0,0.2,0,1.1,0,1.6c0,0.2,0.1,0.2,0.2,0.2h0.3c0,0,0.1,0,0.1,0v0.2 c0,0,0,0-0.1,0c-0.1,0-0.3,0-0.8,0c-0.5,0-0.7,0-0.9,0c0,0,0,0,0,0V5.6c0,0,0,0,0,0h0.4c0.2,0,0.2-0.1,0.2-0.3c0-0.3,0-1.5,0-1.7 V3.3z"/><path d="M6.3,4.1c0,0.1,0,0.2,0,0.3c0,0.6,0.4,1.1,0.9,1.1C7.6,5.5,7.8,5.3,8,5C8,5,8,5,8,5l0.1,0c0,0,0,0,0,0.1 C8,5.4,7.7,5.8,7.1,5.8c-0.4,0-0.8-0.1-1-0.4c-0.2-0.3-0.3-0.6-0.3-1c0-0.2,0.1-0.7,0.4-1c0.3-0.3,0.6-0.3,0.9-0.3 C7.8,3.1,8,3.7,8,4C8,4.1,8,4.1,7.9,4.1H6.3z M7.3,3.9c0.1,0,0.2,0,0.2-0.1c0-0.1-0.1-0.6-0.5-0.6c-0.3,0-0.5,0.2-0.7,0.6H7.3z"/><path d="M10.5,1.9c0-0.2,0-0.3-0.4-0.4c0,0,0,0,0,0V1.4c0,0,0,0,0,0c0.2,0,0.6-0.1,0.7-0.1c0.1,0,0.1,0,0.1,0c0,0,0,0,0,0.1 c0,0.3,0,1.2,0,2v1.4c0,0.2,0,0.5,0.1,0.6c0.1,0.1,0.2,0.1,0.3,0.1c0.1,0,0.1,0,0.1,0l0,0c0,0,0,0.1,0,0.1l-0.7,0.2 c0,0-0.1,0-0.1-0.1l-0.1-0.3c-0.2,0.2-0.6,0.3-0.9,0.3c-0.2,0-0.4,0-0.7-0.3C8.5,5.2,8.4,5,8.4,4.5c0-0.4,0.1-0.8,0.4-1.1 c0.2-0.3,0.6-0.4,0.9-0.4c0.3,0,0.5,0,0.7,0.1V1.9z M10.5,3.9c0-0.1,0-0.2-0.1-0.3c-0.1-0.2-0.3-0.3-0.7-0.3 c-0.2,0-0.4,0.1-0.6,0.2C8.9,3.8,8.9,4.1,8.9,4.3c0,0.7,0.5,1.2,0.9,1.2c0.4,0,0.6-0.2,0.7-0.3c0-0.1,0-0.1,0-0.2V3.9z"/><rect x="0.6" y="6.9" class="st0" width="5" height="1.6"/><rect x="6.4" y="6.9" class="st0" width="5" height="1.6"/><rect x="3.5" y="9.4" class="st0" width="5" height="1.6"/></svg>',
				),
				array(
					'name' => 'acf/headline-link',
					'title' => 'Headline + Link',
					'description' => 'A centered headline, paragraph, and link',
					'category' => 'widgets',
					'icon' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 12" style="enable-background:new 0 0 12 12;" xml:space="preserve"><path d="M1.4,3.3c0-0.4,0-1.2,0-1.3c0-0.3,0-0.4-0.3-0.4H0.8c0,0,0,0,0,0V1.3c0,0,0,0,0.1,0c0.1,0,0.3,0,0.9,0c0.5,0,0.7,0,0.8,0 c0,0,0.1,0,0.1,0v0.2c0,0,0,0,0,0H2.2C2,1.5,2,1.7,2,1.9C2,2,2,2.8,2,3.2v0.1c0,0,0,0,0.1,0h2.3c0.1,0,0.1,0,0.1-0.1V3.2 c0-0.4,0-1.2,0-1.3c0-0.2,0-0.3-0.2-0.3H4c0,0,0,0,0,0V1.3c0,0,0,0,0,0c0.1,0,0.4,0,0.8,0c0.4,0,0.7,0,0.8,0c0,0,0,0,0,0v0.2 c0,0,0,0,0,0H5.3c-0.2,0-0.2,0.1-0.2,0.3c0,0.1,0,1.1,0,1.4v0.2c0,0.2,0,1.4,0,1.8c0,0.2,0.1,0.3,0.3,0.3h0.3c0,0,0.1,0,0.1,0v0.2 c0,0,0,0,0,0c-0.1,0-0.3,0-0.8,0c-0.5,0-0.7,0-0.9,0c0,0,0,0,0,0V5.6c0,0,0,0,0.1,0h0.4c0.2,0,0.2-0.1,0.2-0.3c0-0.3,0-1.3,0-1.5 V3.6c0-0.1,0-0.1-0.1-0.1H2.1C2,3.6,2,3.6,2,3.6v0.1c0,0.2,0,1.1,0,1.6c0,0.2,0.1,0.2,0.2,0.2h0.3c0,0,0.1,0,0.1,0v0.2 c0,0,0,0-0.1,0c-0.1,0-0.3,0-0.8,0c-0.5,0-0.7,0-0.9,0c0,0,0,0,0,0V5.6c0,0,0,0,0,0h0.4c0.2,0,0.2-0.1,0.2-0.3c0-0.3,0-1.5,0-1.7 V3.3z"/><path d="M6.3,4.1c0,0.1,0,0.2,0,0.3c0,0.6,0.4,1.1,0.9,1.1C7.6,5.5,7.8,5.3,8,5C8,5,8,5,8,5l0.1,0c0,0,0,0,0,0.1 C8,5.4,7.7,5.8,7.1,5.8c-0.4,0-0.8-0.1-1-0.4c-0.2-0.3-0.3-0.6-0.3-1c0-0.2,0.1-0.7,0.4-1c0.3-0.3,0.6-0.3,0.9-0.3 C7.8,3.1,8,3.7,8,4C8,4.1,8,4.1,7.9,4.1H6.3z M7.3,3.9c0.1,0,0.2,0,0.2-0.1c0-0.1-0.1-0.6-0.5-0.6c-0.3,0-0.5,0.2-0.7,0.6H7.3z"/><path d="M10.5,1.9c0-0.2,0-0.3-0.4-0.4c0,0,0,0,0,0V1.4c0,0,0,0,0,0c0.2,0,0.6-0.1,0.7-0.1c0.1,0,0.1,0,0.1,0c0,0,0,0,0,0.1 c0,0.3,0,1.2,0,2v1.4c0,0.2,0,0.5,0.1,0.6c0.1,0.1,0.2,0.1,0.3,0.1c0.1,0,0.1,0,0.1,0l0,0c0,0,0,0.1,0,0.1l-0.7,0.2 c0,0-0.1,0-0.1-0.1l-0.1-0.3c-0.2,0.2-0.6,0.3-0.9,0.3c-0.2,0-0.4,0-0.7-0.3C8.5,5.2,8.4,5,8.4,4.5c0-0.4,0.1-0.8,0.4-1.1 c0.2-0.3,0.6-0.4,0.9-0.4c0.3,0,0.5,0,0.7,0.1V1.9z M10.5,3.9c0-0.1,0-0.2-0.1-0.3c-0.1-0.2-0.3-0.3-0.7-0.3 c-0.2,0-0.4,0.1-0.6,0.2C8.9,3.8,8.9,4.1,8.9,4.3c0,0.7,0.5,1.2,0.9,1.2c0.4,0,0.6-0.2,0.7-0.3c0-0.1,0-0.1,0-0.2V3.9z"/><path d="M10.2,7.2H1.9v0.6h8.3V7.2z M9.3,8.4H2.8V9h6.5V8.4z M10.2,9.7H1.9v0.6h8.3V9.7z"/></svg>',
				),
				array(
					'name' => 'acf/interactive-content-pane',
					'title' => 'Interactive Content Pane',
					'description' => 'A block with a photo background and a menu of links that open longer excerpts',
					'category' => 'widgets',
					'icon' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 12 12"><path d="M9.8,2.9H0v.9h9.8v-.9ZM.8,10v-4.7H0v4.7h.8ZM10.6,1.2H0v.9h10.6v-.9ZM8.9,5.3H2.8v.4h6.1v-.4ZM9.6,6.7H2.8v.4h6.8v-.4ZM10.2,8.1H2.8v.4h7.4v-.4ZM8.8,9.4H2.8v.4h6v-.4ZM.8,6.2l1,.7-1,.8v-1.5Z"/></svg>', //'align-pull-right',
				),
				array(
					'name' => 'acf/quote-carousel',
					'title' => 'Quote Carousel',
					'description' => 'A slider made of squares containing photos and short blurbs or quotes',
					'category' => 'widgets',
					'icon' => 'format-chat',
				),
/*
				array(
					'name' => 'acf/scrolling-content-pane',
					'title' => 'Scrolling Content Pane',
					'description' => 'A block with a photo background and a menu of links that appear on scroll',
					'category' => 'widgets',
					'icon' => 'align-pull-right',
				),
*/
				array(
					'name' => 'acf/social-links',
					'title' => 'Social Links',
					'description' => 'A set of links to social media pages',
					'category' => 'widgets',
					'icon' => 'share-alt',
				),
				array(
					'name' => 'acf/statistics',
					'title' => 'Statistics',
					'description' => 'A grid of oversize numbers with descriptions underneath',
					'category' => 'widgets',
					'icon' => 'chart-bar',
				),
				array(
					'name' => 'acf/video-text',
					'title' => 'Video + Text',
					'description' => 'A video preceded by a title and introduction with a background cover photo',
					'category' => 'widgets',
					'icon' => 'video-alt2',
				),
	
			);
	
			foreach( $pulpfree_acf_blocks as $b ) {
				acf_register_block(array(
					'name'              => $b['name'],
					'title'             => $b['title'],
					'description'       => $b['description'],
					'render_callback'   => 'pulpfree_block_render_callback',
					'category'          => $b['category'],
					'icon'              => $b['icon'],
					'align'				=> 'full',
				));
			}
		}
	}
	
	/**
	 * Block markup is stored under the theme’s "acf/" subdirectory
	 */

	function pulpfree_block_render_callback( $block ) {
		$slug = str_replace('acf/', '', $block['name']);
		if( file_exists( get_theme_file_path("/blocks/{$slug}.php") ) ) {
			include( get_theme_file_path("/blocks/{$slug}.php") );
		}
	}


/*--------------------------------------------------------------
 * 9.0	Customizations
 *------------------------------------------------------------*/

	/**
	 * Customize screen options
	 */
	add_action('customize_register', 'pulpfree_options_customize');
	function pulpfree_options_customize($wp_customize) {


		/*--------------------------------------------------------------
		 * 9.1	Suggested Searches
		 *------------------------------------------------------------*/

		$wp_customize->add_section( 'pulpfree_suggested_searches', array(
			'title'          => 'Suggested Searches',
			'priority'       => 36
		) );

		$wp_customize->add_setting( 'suggested_searches', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'option',
		) );

		$wp_customize->add_control( 'suggested_searches', array(
			'label'       => __( 'Suggested Searches' ),
			'description' => __( 'These search keywords will appear under the search box, linked to search results for each term.' ),
			'section'     => 'pulpfree_suggested_searches',
			'settings'    => 'suggested_searches',
			'type'        => 'textarea',
		) );


		/*--------------------------------------------------------------
		 * 9.2	Menu Photo
		 *------------------------------------------------------------*/

		$wp_customize->add_section( 'pulpfree_menu_photo', array(
			'title'          => 'Menu Photo',
			'priority'       => 37
		) );

		$wp_customize->add_setting( 'menu_photo', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'option',
		) );

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'menu_photo', array(
			'label'            => 'Current Image Selection',
			'section'          => 'pulpfree_menu_photo',
			'settings'         => 'menu_photo'
		)));


	}


/*--------------------------------------------------------------
 * 10.0	Admin AJAX
 *------------------------------------------------------------*/

	require get_template_directory() . '/functions/admin-ajax.php';


/*--------------------------------------------------------------
 * 11.0	Scheduled Actions
 *------------------------------------------------------------*/

	require get_template_directory() . '/functions/scheduled-actions.php';
