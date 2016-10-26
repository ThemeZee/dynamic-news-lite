<?php
/*
Template Name: Post Slider
*/
?>
<?php get_header(); ?>

	<div id="wrap" class="container clearfix">

		<section id="content" class="primary" role="main">

		<?php if ( function_exists( 'themezee_breadcrumbs' ) ) { themezee_breadcrumbs(); } ?>

		<?php // Display Featured Post Slideshow
		get_template_part( 'featured-content-slider' );
		?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );

			endwhile;

		endif; ?>

		<?php comments_template(); ?>

		</section>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
