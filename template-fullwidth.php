<?php
/*
Template Name: Fullwidth
*/
?>
<?php get_header(); ?>

	<div id="wrap" class="container clearfix template-fullwidth">
		
		<section id="content-full" class="clearfix" role="main">
		
		<?php if ( function_exists( 'themezee_breadcrumbs' ) ) themezee_breadcrumbs(); ?>
			
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
			<div <?php post_class(); ?>>
				
				<h2 class="page-title"><span><?php the_title(); ?></span></h2>
				
				<div class="entry clearfix">
					<?php the_content(); ?>
				</div>
				<?php wp_link_pages(); ?>
				
			</div>

		<?php endwhile; ?>

		<?php endif; ?>
		
		<?php comments_template(); ?>
		
		</section>

	</div>
	
<?php get_footer(); ?>