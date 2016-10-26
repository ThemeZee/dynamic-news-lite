<?php do_action( 'dynamicnews_before_footer' ); ?>

	<div id="footer-wrap">

		<footer id="footer" class="container clearfix" role="contentinfo">

			<div id="footer-text">
				<?php do_action( 'dynamicnews_footer_text' ); ?>
			</div>

			<?php // Check if there is a top navigation menu.
			if ( has_nav_menu( 'footer' ) ) : ?>

				<nav id="footernav" class="clearfix" role="navigation">
					<h4 id="footernav-icon"></h4>
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

		</footer>

	</div>

</div><!-- end #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
