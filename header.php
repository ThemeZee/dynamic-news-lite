<!DOCTYPE html><!-- HTML 5 -->
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'dynamic-news-lite' ); ?></a>

<div id="wrapper" class="hfeed">

	<div id="topnavi-wrap">
		<?php get_template_part( 'inc/top-navigation' ); ?>
	</div>

	<div id="header-wrap">

		<header id="header" class="container clearfix" role="banner">

			<div id="logo" class="clearfix">

				<?php dynamicnews_site_logo(); ?>
				<?php dynamicnews_site_title(); ?>
				<?php dynamicnews_site_description(); ?>

			</div>

			<div id="header-content" class="clearfix">
				<?php get_template_part( 'inc/header-content' ); ?>
			</div>

		</header>

	</div>

	<div id="navi-wrap">
		<nav id="mainnav" class="container clearfix" role="navigation">
			<?php
				// Get Navigation out of Theme Options
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container' => false,
					'menu_id' => 'mainnav-menu',
					'menu_class' => 'main-navigation-menu',
					'echo' => true,
					'fallback_cb' => 'dynamicnews_default_menu',
					'depth' => 0,
				) );
			?>
		</nav>
	</div>

	<?php // Display Custom Header Image
		dynamicnews_display_custom_header(); ?>
