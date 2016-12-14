<?php
/***
 * Template Tags
 *
 * This file contains several template functions which are used to print out specific HTML markup
 * in the theme. You can override these template functions within your child theme.
 *
 */


if ( ! function_exists( 'dynamicnews_site_logo' ) ) :
	/**
 * Displays the site logo in the header area
 */
	function dynamicnews_site_logo() {

		if ( function_exists( 'the_custom_logo' ) ) {

			the_custom_logo();

		}

	}
endif;


if ( ! function_exists( 'dynamicnews_site_title' ) ) :
	/**
 * Displays the site title in the header area
 */
	function dynamicnews_site_title() {

		if ( is_home() or is_page_template( 'template-frontpage.php' )  ) : ?>

			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

		<?php else : ?>

		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>

	<?php endif;

	}
endif;


if ( ! function_exists( 'dynamicnews_site_description' ) ) :
	/**
	 * Displays the site description in the header area
	 */
	function dynamicnews_site_description() {

		$description = get_bloginfo( 'description', 'display' ); /* WPCS: xss ok. */

		if ( $description || is_customize_preview() ) : ?>

			<p class="site-description"><?php echo $description; ?></p>

		<?php
		endif;
	}
endif;


// Display Custom Header
if ( ! function_exists( 'dynamicnews_display_custom_header' ) ) :

	function dynamicnews_display_custom_header() {

		// Get theme options from database
		$theme_options = dynamicnews_theme_options();

		// Hide header image on front page
		if ( true == $theme_options['custom_header_hide'] and is_front_page() ) {
			return;
		}

		// Check if page is displayed and featured header image is used
		if ( is_page() && has_post_thumbnail() ) : ?>

			<div id="custom-header" class="featured-image-header">
				<?php the_post_thumbnail( 'custom_header_image' ); ?>
			</div>

		<?php
		// Check if there is a custom header image
		elseif ( get_header_image() ) : ?>

			<div id="custom-header">

				<?php // Check if custom header image is linked
				if ( '' !== $theme_options['custom_header_link'] ) : ?>

					<a href="<?php echo esc_url( $theme_options['custom_header_link'] ); ?>">
						<img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id, 'full' ) ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					</a>

				<?php else : ?>

					<img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id, 'full' ) ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">

				<?php endif; ?>

			</div>

		<?php
		endif;
	}

endif;


// Display Postmeta Data
if ( ! function_exists( 'dynamicnews_display_postmeta' ) ) :

	function dynamicnews_display_postmeta() {

		// Get Theme Options from Database
		$theme_options = dynamicnews_theme_options();

		// Display Date unless user has deactivated it via settings
		if ( true == $theme_options['meta_date'] ) :

			dynamicnews_meta_date();

		endif;

		// Display Author unless user has deactivated it via settings
		if ( true == $theme_options['meta_author'] ) :

			dynamicnews_meta_author();

		endif;

		// Display Comments
		if ( comments_open() ) :

			dynamicnews_meta_comments();

		endif;

		edit_post_link( esc_html__( 'Edit Post', 'dynamic-news-lite' ) );
	}

endif;


// Display Post Date
function dynamicnews_meta_date() {

	$time_string = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date published updated" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	echo '<span class="meta-date sep">' . $time_string . '</span>';
}


// Display Post Author
function dynamicnews_meta_author() {

	$author_string = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( esc_html__( 'View all posts by %s', 'dynamic-news-lite' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);

	echo '<span class="meta-author sep"> ' . $author_string . '</span>';

}


// Display Post Meta Comments
function dynamicnews_meta_comments() {
	?>

	<span class="meta-comments">
		<?php comments_popup_link( esc_html__( 'Leave a comment', 'dynamic-news-lite' ), esc_html__( 'One comment', 'dynamic-news-lite' ), esc_html__( '% comments', 'dynamic-news-lite' ) ); ?>
	</span>

	<?php
}


// Display Post Thumbnail on Archive Pages
function dynamicnews_display_thumbnail_index() {

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Display Post Thumbnail if activated
	if ( true == $theme_options['post_thumbnails_index'] ) : ?>

		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<?php the_post_thumbnail( 'featured_image' ); ?>
		</a>

	<?php
	endif;
}


// Display Post Thumbnail on single posts
function dynamicnews_display_thumbnail_single() {

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Display Post Thumbnail if activated
	if ( true == $theme_options['post_thumbnails_single'] ) :

		the_post_thumbnail( 'featured_image' );

	endif;
}


// Display Postinfo Data on Archive Pages
if ( ! function_exists( 'dynamicnews_display_postinfo_index' ) ) :

	function dynamicnews_display_postinfo_index() {

		// Get Theme Options from Database
		$theme_options = dynamicnews_theme_options();

		// Display Date unless user has deactivated it via settings
		if ( true == $theme_options['meta_category'] ) : ?>

			<span class="meta-category">
				<?php echo get_the_category_list( '' ); ?>
			</span>

		<?php
		endif;
	}

endif;

// Display Postinfo Data on single posts
if ( ! function_exists( 'dynamicnews_display_postinfo_single' ) ) :

	function dynamicnews_display_postinfo_single() {

		// Get Theme Options from Database
		$theme_options = dynamicnews_theme_options();

		// Display Date unless user has deactivated it via settings
		if ( true == $theme_options['meta_tags'] ) :

			$tag_list = get_the_tag_list( '', ', ' );

			if ( $tag_list ) : ?>

				<span class="meta-tags">
					<?php printf( esc_html__( 'tagged with %1$s', 'dynamic-news-lite' ), $tag_list ); ?>
				</span>

			<?php endif;

		endif;

		// Display Categories
		dynamicnews_display_postinfo_index();

	}

endif;


// Display Single Post Navigation
if ( ! function_exists( 'dynamicnews_display_post_navigation' ) ) :

	function dynamicnews_display_post_navigation() {

		// Get Theme Options from Database
		$theme_options = dynamicnews_theme_options();

		if ( true == $theme_options['post_navigation'] ) {

			the_post_navigation( array( 'prev_text' => '&laquo; %title', 'next_text' => '%title &raquo;' ) );

		}
	}

endif;


// Display ThemeZee Related Posts plugin
if ( ! function_exists( 'dynamicnews_display_related_posts' ) ) :

	function dynamicnews_display_related_posts() {

		if ( function_exists( 'themezee_related_posts' ) ) {

			themezee_related_posts( array(
				'class' => 'related-posts type-page clearfix',
				'before_title' => '<h2 class="entry-title">',
				'after_title' => '</h2>',
			) );

		}
	}

endif;


// Display Content Pagination
if ( ! function_exists( 'dynamicnews_display_pagination' ) ) :

	function dynamicnews_display_pagination() {

		global $wp_query;

		$big = 999999999; // need an unlikely integer

		 $paginate_links = paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var( 'paged' ) ),
				'total' => $wp_query->max_num_pages,
				'next_text' => '&raquo;',
				'prev_text' => '&laquo',
				'add_args' => false,
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


// Display Footer Text
add_action( 'dynamicnews_footer_text', 'dynamicnews_display_footer_text' );

function dynamicnews_display_footer_text() {
	?>

	<span class="credit-link">
		<?php printf( esc_html__( 'Powered by %1$s and %2$s.', 'dynamic-news-lite' ),
			'<a href="http://wordpress.org" title="WordPress">WordPress</a>',
			'<a href="https://themezee.com/themes/dynamicnews/" title="Dynamic News WordPress Theme">Dynamic News</a>'
		); ?>
	</span>

	<?php
}


// Display Social Icons
function dynamicnews_display_social_icons() {

	// Check if there is a social_icons menu
	if ( has_nav_menu( 'social' ) ) :

		// Display Social Icons Menu
		wp_nav_menu( array(
			'theme_location' => 'social',
			'container' => false,
			'menu_id' => 'social-icons-menu',
			'menu_class' => 'social-icons-menu',
			'echo' => true,
			'fallback_cb' => '',
			'before' => '',
			'after' => '',
			'link_before' => '<span class="screen-reader-text">',
			'link_after' => '</span>',
			'depth' => 1,
			)
		);

	else : // Display Hint how to configure Social Icons ?>

		<p class="social-icons-hint">
			<?php esc_html_e( 'Please go to Appearance &#8594; Menus and create a new custom menu with custom links to all your social networks. Then click on "Manage Locations" tab and assign your created menu to the "Social Icons" location.', 'dynamic-news-lite' ); ?>
		</p>
<?php
	endif;

}


// Custom Template for comments and pingbacks.
if ( ! function_exists( 'dynamicnews_list_comments' ) ) :
	function dynamicnews_list_comments( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment;

		if ( 'pingback' === $comment->comment_type or 'trackback' === $comment->comment_type ) : ?>

			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php esc_html_e( 'Pingback:', 'dynamic-news-lite' ); ?> <?php comment_author_link(); ?>
				<?php edit_comment_link( esc_html__( '(Edit)', 'dynamic-news-lite' ), '<span class="edit-link">', '</span>' ); ?>
				</p>

		<?php else : ?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<div class="comment-author vcard clearfix">
					<span class="fn"><?php echo get_comment_author_link(); ?></span>
					<div class="comment-meta commentmetadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php echo get_comment_date(); ?>
							<?php echo get_comment_time(); ?>
						</a>
						<?php edit_comment_link( esc_html__( '(Edit)', 'dynamic-news-lite' ),'  ','' ) ?>
					</div>

				</div>

				<div class="comment-content clearfix">

					<?php echo get_avatar( $comment, 72 ); ?>

					<?php if ( 0 === $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'dynamic-news-lite' ); ?></p>
					<?php endif; ?>

					<?php comment_text(); ?>

				</div>

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				</div>

			</div>

		<?php
		endif;
	}
endif;
