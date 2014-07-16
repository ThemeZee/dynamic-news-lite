		
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<h2 class="post-title"><a href="<?php esc_url(the_permalink()) ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		
		<div class="postmeta"><?php dynamicnews_display_postmeta(); ?></div>
	
		<?php dynamicnews_display_thumbnail_index(); ?>
		
		<div class="entry clearfix">
			<?php $read_more_text = '<span>' . __('Read more', 'dynamicnewslite') . '</span>'; ?>
			<?php the_content($read_more_text); ?>
			<div class="page-links"><?php wp_link_pages(); ?></div>
		</div>
		
		<div class="postinfo clearfix"><?php dynamicnews_display_postinfo_index(); ?></div>

	</article>