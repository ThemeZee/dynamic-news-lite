<!DOCTYPE html><!-- HTML 5 -->
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php // Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
?>

<div id="wrapper" class="hfeed">
	
	<div id="header-wrap">
	
		<header id="header" class="container clearfix" role="banner">

			<div id="logo" class="clearfix">
			
				<?php do_action('dynamicnews_site_title'); ?>
				
				<?php // Display Tagline on header if activated
				if ( isset($theme_options['header_tagline']) and $theme_options['header_tagline'] == true ) : ?>			
					<h2 class="site-description"><?php echo bloginfo('description'); ?></h2>
				<?php endif; ?>
			
			</div>
			
			<div id="header-content" class="clearfix">
				<?php get_template_part('inc/header-content'); ?>
			</div>

		</header>
	
	</div>
	
	<div id="navi-wrap">
		<nav id="mainnav" class="container clearfix" role="navigation">
			<h4 id="mainnav-icon"><?php _e('Menu', 'dynamicnewslite'); ?></h4>
			<?php 
				// Get Navigation out of Theme Options
				wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_id' => 'mainnav-menu', 'echo' => true, 'fallback_cb' => 'dynamicnews_default_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'depth' => 0));
			?>
		</nav>
	</div>
	
	<?php // Display Custom Header Image
		dynamicnews_display_custom_header(); ?>
		