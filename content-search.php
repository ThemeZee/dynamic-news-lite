
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
		<h2 class="post-title"><a href="<?php esc_url(the_permalink()) ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<div class="entry clearfix">
			<?php the_excerpt(); ?>
			<a href="<?php esc_url(the_permalink()) ?>" class="more-link"><?php _e('Read more', 'dynamicnewslite'); ?></a>			
		</div>

	</div>