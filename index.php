<?php get_header(); ?>

<?php // Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
?>

	<div id="wrap" class="container clearfix">
	
		<section id="content" class="primary" role="main">
		
		<?php // Display Featured Post Slideshow if activated
		if ( isset($theme_options['slider_activated_blog']) and $theme_options['slider_activated_blog'] == true ) :

			get_template_part( 'featured-content-slider' );

		endif; ?>
		 
		<?php if (have_posts()) : while (have_posts()) : the_post();
		
			get_template_part( 'content', $theme_options['posts_length'] );
		
			endwhile;
			
		dynamicnews_display_pagination();

		endif; ?>
			
		</section>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>	