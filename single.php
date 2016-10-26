<?php get_header(); ?>

	<div id="wrap" class="container clearfix">
		
		<section id="content" class="primary" role="main">
		
		<?php if ( function_exists( 'themezee_breadcrumbs' ) ) { themezee_breadcrumbs();} ?>
			
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

				get_template_part( 'content', 'single' );

			endwhile;

		endif; ?>
		
		<?php dynamicnews_display_post_navigation(); ?>
			
		<?php dynamicnews_display_related_posts(); ?>
			
		<?php comments_template(); ?>
		
		</section>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>
