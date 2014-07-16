
	<div id="footer-wrap">
	
		<footer id="footer" class="container clearfix" role="contentinfo">
			<nav id="footernav" class="clearfix" role="navigation">
				<?php 
					// Get Navigation out of Theme Options
					wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'menu_id' => 'footernav-menu', 'echo' => true, 'fallback_cb' => '', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'depth' => 1));
				?>
			</nav>
			<div id="credit-link"><?php dynamicnews_credit_link(); ?></div>
		</footer>
		
	</div>

</div><!-- end #wrapper -->

<?php wp_footer(); ?>
</body>
</html>