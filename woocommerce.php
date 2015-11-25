<?php get_header(); ?>

	<div id="wrap" class="container clearfix">
		
		<section id="content" class="primary" role="main">
		
			<div id="post-<?php the_ID(); ?>" <?php post_class('type-page clearfix'); ?>>
			
				<?php woocommerce_content(); ?>
				
			</div>
				
		</section>
		
		<?php get_sidebar(); ?>
		
	</div>
	
<?php get_footer(); ?>