<?php

/*==================================== THEME SETUP ====================================*/

// Load default style.css and Javascripts
add_action('wp_enqueue_scripts', 'dynamicnews_enqueue_scripts');

if ( ! function_exists( 'dynamicnews_enqueue_scripts' ) ):
function dynamicnews_enqueue_scripts() {

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Register and Enqueue Stylesheet
	wp_enqueue_style('dynamicnewslite-stylesheet', get_stylesheet_uri());
	
	// Register Genericons
	wp_enqueue_style('dynamicnewslite-genericons', get_template_directory_uri() . '/css/genericons.css');

	// Register and Enqueue FlexSlider JS and CSS if necessary
	if ( ( isset($theme_options['slider_activated_blog']) and $theme_options['slider_activated_blog'] == true )
		|| ( isset($theme_options['slider_activated_front_page']) and $theme_options['slider_activated_front_page'] == true ) ) :

		// FlexSlider CSS
		wp_enqueue_style('dynamicnewslite-flexslider', get_template_directory_uri() . '/css/flexslider.css');

		// FlexSlider JS
		wp_enqueue_script('dynamicnewslite-jquery-flexslider', get_template_directory_uri() .'/js/jquery.flexslider-min.js', array('jquery'));

		// Register and enqueue slider.js
		wp_enqueue_script('dynamicnewslite-jquery-frontpage_slider', get_template_directory_uri() .'/js/slider.js', array('dynamicnewslite-jquery-flexslider'));

	endif;

	// Register and enqueue navigation.js
	wp_enqueue_script('dynamicnewslite-jquery-navigation', get_template_directory_uri() .'/js/navigation.js', array('jquery'));
	
	// Register and Enqueue Font
	wp_enqueue_style('dynamicnewslite-lite-default-font', '//fonts.googleapis.com/css?family=Droid+Sans');
	wp_enqueue_style('dynamicnewslite-lite-default-title-font', '//fonts.googleapis.com/css?family=Francois+One');
}
endif;

// Load comment-reply.js if comment form is loaded and threaded comments activated
add_action( 'comment_form_before', 'dynamicnews_enqueue_comment_reply' );

function dynamicnews_enqueue_comment_reply() {
	if( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

// HTML5shiv for old IE
add_action('wp_head', 'dynamicnews_enqueue_html5shiv');

function dynamicnews_enqueue_html5shiv(){
    
	/* Embeds HTML5shiv to support HTML5 elements in older IE versions plus CSS Backgrounds */ ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	
<?php
}


// Setup Function: Registers support for various WordPress features
add_action( 'after_setup_theme', 'dynamicnews_setup' );

if ( ! function_exists( 'dynamicnews_setup' ) ):
function dynamicnews_setup() {

	// Set Content Width
	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 860;
		
	// init Localization
	load_theme_textdomain('dynamicnewslite', get_template_directory() . '/languages' );

	// Add Theme Support
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_editor_style();
	
	// Add Custom Background
	add_theme_support('custom-background', array('default-color' => 'e5e5e5'));

	// Add Custom Header
	add_theme_support('custom-header', array(
		'header-text' => false,
		'width'	=> 1340,
		'height' => 200,
		'flex-height' => true));
		
	// Add theme support for Jetpack Featured Content
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'dynamicnews_get_featured_content',
		'max_posts'  => 20
		)
	);

	// Register Navigation Menus
	register_nav_menu( 'primary', __('Main Navigation', 'dynamicnewslite') );
	register_nav_menu( 'footer', __('Footer Navigation', 'dynamicnewslite') );
	
	// Register Social Icons Menu
	register_nav_menu( 'social', __('Social Icons', 'dynamicnewslite') );

}
endif;


// Add custom Image Sizes
add_action( 'after_setup_theme', 'dynamicnews_add_image_sizes' );

if ( ! function_exists( 'dynamicnews_add_image_sizes' ) ):
function dynamicnews_add_image_sizes() {

	// Add Custom Header Image Size
	add_image_size( 'custom_header_image', 1340, 200, true);

	// Add Featured Image Size
	add_image_size( 'featured_image', 860, 280, true);

	// Add Slider Image Size
	add_image_size( 'slider_image', 880, 290, true);

	// Add Frontpage Thumbnail Sizes
	add_image_size( 'category_posts_wide_thumb', 420, 140, true);
	add_image_size( 'category_posts_small_thumb', 90, 90, true);

	// Add Widget Post Thumbnail Size
	add_image_size( 'widget_post_thumb', 75, 75, true);

}
endif;


// Register Sidebars
add_action( 'widgets_init', 'dynamicnews_register_sidebars' );

if ( ! function_exists( 'dynamicnews_register_sidebars' ) ):
function dynamicnews_register_sidebars() {

	// Register Sidebars
	register_sidebar( array(
		'name' => __( 'Sidebar', 'dynamicnewslite' ),
		'id' => 'sidebar',
		'description' => __( 'Appears on posts and pages except front page and fullwidth template.', 'dynamicnewslite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle"><span>',
		'after_title' => '</span></h3>',
	));
	register_sidebar( array(
		'name' => __( 'Magazine Front Page', 'dynamicnewslite' ),
		'id' => 'frontpage-magazine',
		'description' => __( 'Appears on Magazine Front Page page template only. You can use the Category Posts widgets here.', 'dynamicnewslite' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	
}
endif;


/*==================================== THEME FUNCTIONS ====================================*/

// Creates a better title element text for output in the head section
add_filter( 'wp_title', 'dynamicnews_wp_title', 10, 2 );

function dynamicnews_wp_title( $title, $sep = '' ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'dynamicnewslite' ), max( $paged, $page ) );

	return $title;
}


// Add Default Menu Fallback Function
function dynamicnews_default_menu() {
	echo '<ul id="mainnav-menu" class="menu">'. wp_list_pages('title_li=&echo=0') .'</ul>';
}


// Get Featured Posts
function dynamicnews_get_featured_content() {
	return apply_filters( 'dynamicnews_get_featured_content', false );
}


// Display Credit Link Function
function dynamicnews_credit_link() {
	
	printf(__( 'Powered by %1$s and %2$s.', 'dynamicnewslite' ), 
			sprintf( '<a href="http://wordpress.org" title="WordPress">%s</a>', __( 'WordPress', 'dynamicnewslite' ) ),
			sprintf( '<a href="http://themezee.com/themes/dynamicnews/" title="Dynamic News WordPress Theme">%s</a>', __( 'Dynamic News', 'dynamicnewslite' ) )
		);
}


// Change Excerpt Length
add_filter('excerpt_length', 'dynamicnews_excerpt_length');
function dynamicnews_excerpt_length($length) {
    return 60;
}


// Slideshow Excerpt Length
function dynamicnews_slideshow_excerpt_length($length) {
    return 30;
}

// Frontpage Category Excerpt Length
function dynamicnews_frontpage_category_excerpt_length($length) {
    return 25;
}


// Change Excerpt More
add_filter('excerpt_more', 'dynamicnews_excerpt_more');
function dynamicnews_excerpt_more($more) {
    
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Return Excerpt Text
	if ( isset($theme_options['excerpt_text']) and $theme_options['excerpt_text'] == true ) :
		return ' [...]';
	else :
		return '';
	endif;
}


// Custom Template for comments and pingbacks.
if ( ! function_exists( 'dynamicnews_list_comments' ) ):
function dynamicnews_list_comments($comment, $args, $depth) {

	$GLOBALS['comment'] = $comment;

	if( $comment->comment_type == 'pingback' or $comment->comment_type == 'trackback' ) : ?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', 'dynamicnewslite' ); ?> <?php comment_author_link(); ?>
			<?php edit_comment_link( __( '(Edit)', 'dynamicnewslite' ), '<span class="edit-link">', '</span>' ); ?>
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
						<?php edit_comment_link(__('(Edit)', 'dynamicnewslite'),'  ','') ?>
					</div>

				</div>

				<div class="comment-content clearfix">

					<?php echo get_avatar( $comment, 72 ); ?>

					<?php if ($comment->comment_approved == '0') : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'dynamicnewslite' ); ?></p>
					<?php endif; ?>

					<?php comment_text(); ?>

				</div>

				<div class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>

			</div>

<?php
	endif;

}
endif;


/*==================================== INCLUDE FILES ====================================*/

// include Theme Info page
require( get_template_directory() . '/inc/theme-info.php' );

// include Theme Customizer Options
require( get_template_directory() . '/inc/customizer/customizer.php' );
require( get_template_directory() . '/inc/customizer/default-options.php' );

// include Customization Files
require( get_template_directory() . '/inc/customizer/frontend/custom-layout.php' );
require( get_template_directory() . '/inc/customizer/frontend/custom-jscript.php' );

// include Template Functions
require( get_template_directory() . '/inc/template-tags.php' );
require( get_template_directory() . '/inc/front-page-functions.php' );

// include Widget Files
require( get_template_directory() . '/inc/widgets/widget-category-posts-boxed.php' );
require( get_template_directory() . '/inc/widgets/widget-category-posts-columns.php' );
require( get_template_directory() . '/inc/widgets/widget-category-posts-grid.php' );

// Include Featured Content class in case it does not exist yet (e.g. user has not Jetpack installed)
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require( get_template_directory() . '/inc/featured-content.php' );
}

?>