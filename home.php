<?php get_header(); ?>

<?php // Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
?>

	<div id="wrap" class="container clearfix">

		<section id="content" class="primary" role="main">

		<?php if ( function_exists( 'themezee_breadcrumbs' ) ) { themezee_breadcrumbs(); } ?>

		<?php // Display Featured Post Slideshow if activated
		if ( true == $theme_options['slider_activated_blog'] ) :

			get_template_part( 'featured-content-slider' );

		endif; ?>

		<?php // Display Magazine Homepage Widgets.
		if ( ! is_paged() && is_active_sidebar( 'frontpage-magazine' ) ) : ?>

			<div id="frontpage-magazine-widgets" class="widget-area clearfix">

				<?php dynamic_sidebar( 'frontpage-magazine' ); ?>

			</div><!-- #frontpage-magazine-widgets -->

		<?php endif; ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

				get_template_part( 'content', $theme_options['posts_length'] );

			endwhile;

		dynamicnews_display_pagination();

		endif; ?>

		</section>

		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>
