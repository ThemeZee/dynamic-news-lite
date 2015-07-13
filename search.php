<?php get_header(); ?>

<?php // Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
?>

	<div id="wrap" class="container clearfix">
		
		<section id="content" class="primary" role="main">
		
			<header class="page-header">
				<h2 id="search-title" class="archive-title">
					<?php printf( __( 'Search Results for: %s', 'dynamicnewslite' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h2>
			</header>
			
		<?php if (have_posts()) : while (have_posts()) : the_post();
		
				if ( 'post' == get_post_type() ) :
		
					get_template_part( 'content', $theme_options['posts_length'] );
				
				else :
				
					get_template_part( 'content', 'search' );
					
				endif;
		
			endwhile;
			
			dynamicnews_display_pagination();

		else : ?>
			
			<div class="post">
				
				<div class="entry">
					<p><?php _e('No matches. Please try again, or use the navigation menus to find what you search for.', 'dynamicnewslite'); ?></p>
				</div>
				
			</div>

			<?php endif; ?>
			
		</section>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>	