<?php
/***
 * Template Tags
 *
 * This file contains several template functions which are used to print out specific HTML markup
 * in the theme. You can override these template functions within your child theme.
 *
 */
	

// Display Custom Header
if ( ! function_exists( 'dynamicnews_display_custom_header' ) ):
	
	function dynamicnews_display_custom_header() {
		
		// Check if page is displayed and featured header image is used
		if( is_page() && has_post_thumbnail() ) :
		?>
			<div id="custom-header" class="featured-image-header">
				<?php the_post_thumbnail('custom_header_image'); ?>
			</div>
<?php
		// Check if there is a custom header image
		elseif( get_header_image() ) :
		?>
			<div id="custom-header">
				<img src="<?php echo get_header_image(); ?>" />
			</div>
<?php 
		endif;

	}
	
endif;


// Display Postmeta Data
if ( ! function_exists( 'dynamicnews_display_postmeta' ) ):
	
	function dynamicnews_display_postmeta() { ?>
		
		<span class="meta-date">
		<?php printf(__('<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s">%4$s</time></a>', 'dynamicnewslite'), 
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			);
		?>
		</span>
		
		<span class="meta-author sep">
		<?php printf(__('<a href="%1$s" title="%2$s" rel="author">%3$s</a>', 'dynamicnewslite'), 
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'dynamicnewslite' ), get_the_author() ) ),
				get_the_author()
			);
		?>
		</span>
		
	<?php if ( comments_open() ) : ?>
		
		<span class="meta-comments sep">
			<?php comments_popup_link( __('Leave a comment', 'dynamicnewslite'),__('One comment','dynamicnewslite'),__('% comments','dynamicnewslite') ); ?>
		</span>
		
	<?php endif; ?>
	
	<?php
		edit_post_link(__( 'Edit Post', 'dynamicnewslite' ));
	}
	
endif;


// Display Post Thumbnail on Archive Pages
function dynamicnews_display_thumbnail_index() {
	
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Display Post Thumbnail if activated
	if ( isset($theme_options['post_thumbnails_index']) and $theme_options['post_thumbnails_index'] == true ) : ?>

		<a href="<?php esc_url(the_permalink()) ?>" rel="bookmark">
			<?php the_post_thumbnail('featured_image'); ?>
		</a>

<?php
	endif;

}


// Display Post Thumbnail on single posts
function dynamicnews_display_thumbnail_single() {
	
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Display Post Thumbnail if activated
	if ( isset($theme_options['post_thumbnails_single']) and $theme_options['post_thumbnails_single'] == true ) :

		the_post_thumbnail('featured_image');

	endif;

}


// Display Postinfo Data on Archive Pages
if ( ! function_exists( 'dynamicnews_display_postinfo_index' ) ):
	
	function dynamicnews_display_postinfo_index() { ?>

		<span class="meta-category">
			<?php echo get_the_category_list(''); ?>
		</span>

	<?php

	}
	
endif;

// Display Postinfo Data on single posts
if ( ! function_exists( 'dynamicnews_display_postinfo_single' ) ):
	
	function dynamicnews_display_postinfo_single() {

		$tag_list = get_the_tag_list('', ', ');
		if ( $tag_list ) : ?>
			<span class="meta-tags">
				<?php printf(__('tagged with %1$s', 'dynamicnewslite'), $tag_list); ?>
			</span>
	<?php
		endif;
	?>

		<span class="meta-category">
			<?php echo get_the_category_list(''); ?>
		</span>

	<?php

	}
	
endif;


	
// Display Content Pagination
if ( ! function_exists( 'dynamicnews_display_pagination' ) ):
	
	function dynamicnews_display_pagination() { 
		
		global $wp_query;

		$big = 999999999; // need an unlikely integer
		
		 $paginate_links = paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',				
				'current' => max( 1, get_query_var( 'paged' ) ),
				'total' => $wp_query->max_num_pages,
				'next_text' => '&raquo;',
				'prev_text' => '&laquo'
			) );

		// Display the pagination if more than one page is found
		if ( $paginate_links ) : ?>
				
			<div class="post-pagination clearfix">
				<?php echo $paginate_links; ?>
			</div>
		
		<?php
		endif;
		
	}
	
endif;


// Display Social Icons
function dynamicnews_display_social_icons() {

	// Check if there is a social_icons menu
	if( has_nav_menu( 'social' ) ) :

		// Display Social Icons Menu
		wp_nav_menu( array(
			'theme_location' => 'social',
			'container' => false,
			'menu_id' => 'social-icons-menu',
			'echo' => true,
			'fallback_cb' => '',
			'before' => '',
			'after' => '',
			'link_before' => '<span class="screen-reader-text">',
			'link_after' => '</span>',
			'depth' => 1
			)
		);

	else: // Display Hint how to configure Social Icons ?>

		<p class="social-icons-hint">
			<?php _e('Please go to WP-Admin-> Appearance-> Menus and create a new custom menu with custom links to all your social networks. Then click on "Manage Locations" tab and assign your created menu to the "Social Icons" theme location.', 'dynamicnewslite'); ?>
		</p>
<?php
	endif;

}


?>