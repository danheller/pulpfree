<?php
	$term_id = get_queried_object_id();
	$term_slug = get_queried_object()->slug;
	$jumpto = get_term_meta( $term_id, 'jump_to', true );
	if( $jumpto ) {
		function compare_name($a, $b) {
			return strcmp($a->name, $b->name);
		}
?>
	<div class="jump">
		<form name="jump-to-term" class="jump-to-term" method="get" action="#">
			<label for="category"><?php _e('Filter by topic','pulpfree'); ?></label>
			<div class="select-container">
				<select id="jump-term" name="category">
					<?php
						// find categories and tags that can be jumped to
						$categories = get_categories();
						$tags = get_tags();
						$terms = array_merge( $categories, $tags );
						usort($terms, "compare_name");
						foreach( $terms as $t ) {
							$jumpto = get_term_meta( $t->term_id, 'jump_to', true );
							if( $jumpto ) {
								echo '<option data-taxonomy="' . esc_attr( $t->taxonomy ) . '" value="' . esc_attr( $t->slug ) . '"';
								if( $term_slug && $t->slug == $term_slug ) {
									echo ' selected="selected"';
								}
								echo '>' . esc_html( $t->name ) . '</option>';
							}
						}
					?>
				</select>
			</div>
			<button type="submit"><?php _e('Show Stories','pulpfree'); ?></button>
		</form>
	</div>
<?php
	}