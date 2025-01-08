			</main>
		</div>
		<footer id="colophon" role="contentinfo" class="site-footer">
			<div class="columns">
			<?php 
				if ( is_active_sidebar( 'footer-column-1' ) ) {
			?>
				<div class="column"><?php dynamic_sidebar( 'footer-column-1' );?></div>
			<?php 
				}
				if ( is_active_sidebar( 'footer-column-2' ) ) { 
			?>
				<div class="column"><?php dynamic_sidebar( 'footer-column-2' );?></div>
			<?php 
				}

				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'menu_id'    => 'menu-footer-menu',
						'menu_class' => 'column',
						'container'  => false,
					)
				);
			?>
			</div>
			<div class="fine-print">
				<div class="copyright">
					Copyright &copy; <?php echo date('Y'); ?> University of Southern California
				</div>
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'compliance-menu',
							'menu_id'    => 'compliance-menu',
							'menu_class' => 'compliance',
							'container'  => false,
						)
					);
				?>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #container -->

	<?php wp_footer(); ?>
	</body>
</html>