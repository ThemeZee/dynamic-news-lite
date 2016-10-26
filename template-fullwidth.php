<?php
/*
Template Name: Fullwidth
*/
?>
<?php get_header(); ?>

	<div id="wrap" class="container clearfix template-fullwidth">

		<section id="content-full" class="clearfix" role="main">

		<?php if ( function_exists( 'themezee_breadcrumbs' ) ) { themezee_breadcrumbs(); } ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );

			endwhile;

		endif; ?>

		<?php comments_template(); ?>

		</section>

	</div>

<?php get_footer(); ?>
