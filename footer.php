<?php do_action( 'dynamicnews_before_footer' ); ?>

	<div id="footer-wrap">

		<footer id="footer" class="container clearfix" role="contentinfo">

			<?php // Check if there is a top navigation menu.
			if ( has_nav_menu( 'footer' ) ) : ?>

				<nav id="footernav" class="clearfix" role="navigation">
					<?php
						// Get Navigation out of Theme Options
						wp_nav_menu( array(
							'theme_location' => 'footer',
							'container' => false,
							'menu_id' => 'footernav-menu',
							'echo' => true,
							'fallback_cb' => '',
							'depth' => 1,
							)
						);
					?>
				</nav>

			<?php endif; ?>

			<div id="footer-text">
				<?php do_action( 'dynamicnews_footer_text' ); ?>
			</div>

		</footer>

	</div>

</div><!-- end #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
