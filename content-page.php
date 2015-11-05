
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

		<div class="entry clearfix">
			<?php the_content(); ?>		
		</div>
		<?php wp_link_pages(); ?>

	</div>