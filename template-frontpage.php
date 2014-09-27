<?php
/*
Template Name: Magazine Front Page
*/
?>
<?php get_header(); ?>

<?php // Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
?>
	
	<div id="wrap" class="container clearfix template-frontpage">
		<section id="content" class="primary" role="main">
		<?php // Display Featured Post Slideshow if activated
		if ( isset($theme_options['slider_activated_front_page']) and $theme_options['slider_activated_front_page'] == true ) :

			get_template_part( 'featured-content-slider' );

		endif; ?>
		
		
		
		<?php // Display Frontpage Widgets
		if(is_active_sidebar('frontpage-magazine')) : ?>

			<div id="frontpage-magazine-widgets" class="clearfix">

				<?php dynamic_sidebar('frontpage-magazine'); ?>

			</div>

		<?php // Display Description about FrontPage Widgets when widget area is empty
		else : ?>

			<p class="frontpage-magazine-no-widgets">
				<?php _e('There are no widgets to be displayed. Please go to Appearance → Widgets and add at least one widget to the "Magazine Front Page" widget area. You can use the three Category Posts widgets to set up the theme like the demo website.', 'dynamicnewslite'); ?>
			</p>

		<?php endif; ?>

		</section>
		
		<?php get_sidebar(); ?>
	
	</div>
	
<?php get_footer(); ?>