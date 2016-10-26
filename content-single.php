
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<?php the_title( '<h1 class="entry-title post-title">', '</h1>' ); ?>
		
		<div class="entry-meta postmeta clearfix"><?php dynamicnews_display_postmeta(); ?></div>
		
		<?php dynamicnews_display_thumbnail_single(); ?>
		
		<div class="entry clearfix">
			<?php the_content(); ?>
			<!-- <?php trackback_rdf(); ?> -->
			<div class="page-links"><?php wp_link_pages(); ?></div>			
		</div>
		
		<div class="postinfo clearfix"><?php dynamicnews_display_postinfo_single(); ?></div>

	</article>
