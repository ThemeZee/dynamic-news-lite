<?php
/***
 * Top Navigation
 *
 * This template displays the top navigation
 *
 */

// Get Theme Options from Database
$theme_options = dynamicnews_theme_options();
?>

	<div id="topnavi" class="container clearfix">

		<?php // Display Social Icons in Navigation
		if ( true === $theme_options['topnavi_icons'] ) : ?>

			<div id="topnavi-social-icons" class="social-icons-wrap clearfix">
				<?php dynamicnews_display_social_icons(); ?>
			</div>

		<?php endif;

		// Display Top Navigation Menu
		if ( has_nav_menu( 'secondary' ) ) : ?>

		<nav id="topnav" class="clearfix" role="navigation">
			<?php // Display Top Navigation
				wp_nav_menu( array(
					'theme_location' => 'secondary',
					'container' => false,
					'menu_id' => 'topnav-menu',
					'menu_class' => 'top-navigation-menu',
					'echo' => true,
					'fallback_cb' => '',
					)
				);
			?>
		</nav>

		<?php endif; ?>

	</div>
