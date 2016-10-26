		
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php the_title( sprintf( '<h2 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		
		<div class="entry-meta postmeta clearfix"><?php dynamicnews_display_postmeta(); ?></div>
	
		<?php dynamicnews_display_thumbnail_index(); ?>
		
		<div class="entry clearfix">
			<?php $read_more_text = '<span>' . esc_html__( 'Read more', 'dynamic-news-lite' ) . '</span>'; ?>
			<?php the_content( $read_more_text ); ?>
			<div class="page-links"><?php wp_link_pages(); ?></div>
		</div>
		
		<div class="postinfo clearfix"><?php dynamicnews_display_postinfo_index(); ?></div>

	</article>
