		
	<article id="post-<?php the_ID(); ?>" <?php post_class('content-excerpt'); ?>>
		
		<?php the_title( sprintf( '<h1 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		
		<div class="postmeta clearfix"><?php dynamicnews_display_postmeta(); ?></div>

		<?php dynamicnews_display_thumbnail_index(); ?>
		
		<div class="entry clearfix">
			<?php the_excerpt(); ?>
			<a href="<?php esc_url(the_permalink()) ?>" class="more-link"><?php esc_html_e( 'Read more', 'dynamic-news-lite' ); ?></a>
		</div>
		
		<div class="postinfo clearfix"><?php dynamicnews_display_postinfo_index(); ?></div>

	</article>