<?php get_header(); ?>

	<div id="wrap" class="container clearfix">
		
		<section id="content" class="primary" role="main">
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<h2 class="post-title"><?php the_title(); ?></h2>
				
				<div class="postmeta"><?php dynamicnews_display_postmeta(); ?></div>

				<div class="entry clearfix"><br/>
					<a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'full' ); ?></a>
					
					<div id="image-nav" class="clearfix">
						<span class="nav-previous"><?php previous_image_link( false, __( 'Previous' , 'dynamicnewslite' ) ); ?></span>
						<span class="nav-next"><?php next_image_link( false, __( 'Next' , 'dynamicnewslite' ) ); ?></span>
					</div>
					
					<?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?>
					<?php the_content(); ?>
					
					<p class="nav-return"><a href="<?php echo esc_url( get_permalink( $post->post_parent )); ?>" title="<?php _e('Return to Gallery', 'dynamicnewslite'); ?>" rel="gallery">
					<?php _e('Return to', 'dynamicnewslite'); ?> <?php echo get_the_title( $post->post_parent ); ?></a></p>

				</div>
				
			</article>
			
		<?php

			endwhile;
		
		endif; ?>
		
		
			
		<?php comments_template(); ?>
		
		</section>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>	