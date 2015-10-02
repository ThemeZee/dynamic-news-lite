<?php

/*==================================== THEME SETUP ====================================*/

// Load default style.css and Javascripts
add_action('wp_enqueue_scripts', 'dynamicnews_enqueue_scripts');

function dynamicnews_enqueue_scripts() {

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Register and Enqueue Stylesheet
	wp_enqueue_style('dynamicnewslite-stylesheet', get_stylesheet_uri());
	
	// Register Genericons
	wp_enqueue_style('dynamicnewslite-genericons', get_template_directory_uri() . '/css/genericons/genericons.css');

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
	
	// Passing Parameters to Navigation.js Javascript
	wp_localize_script( 'dynamicnewslite-jquery-navigation', 'dynamicnews_menu_title', __('Menu', 'dynamic-news-lite') );
	
	// Register Comment Reply Script for Threaded Comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Register and Enqueue Font
	wp_enqueue_style('dynamicnewslite-default-fonts', dynamicnews_fonts_url(), array(), null );

}


// HTML5shiv for old IE
add_action('wp_head', 'dynamicnews_enqueue_html5shiv');

function dynamicnews_enqueue_html5shiv(){
    
	/* Embeds HTML5shiv to support HTML5 elements in older IE versions plus CSS Backgrounds */ ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js" type="text/javascript"></script>
	<![endif]-->
	
<?php
}


/*
* Retrieve Font URL to register default Google Fonts
* Source: http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
*/
function dynamicnews_fonts_url() {
    $fonts_url = '';

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Only embed Google Fonts if not deactivated
	if ( ! ( isset($theme_options['deactivate_google_fonts']) and $theme_options['deactivate_google_fonts'] == true ) ) :
		
		// Set Default Fonts
		$font_families = array('Droid Sans:400,700', 'Francois One');
		 
		// Set Google Font Query Args
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		
		// Create Fonts URL
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		
	endif;
	
	return apply_filters( 'dynamicnews_google_fonts_url', $fonts_url );
}


// Setup Function: Registers support for various WordPress features
add_action( 'after_setup_theme', 'dynamicnews_setup' );

function dynamicnews_setup() {

	// Set Content Width
	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 860;
		
	// init Localization
	load_theme_textdomain('dynamic-news-lite', get_template_directory() . '/languages' );

	// Add Theme Support
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_editor_style();
	
	// Add Custom Background
	add_theme_support('custom-background', array('default-color' => 'e5e5e5'));

	// Add Custom Header
	add_theme_support('custom-header', array(
		'header-text' => false,
		'width'	=> 1340,
		'height' => 200,
		'flex-height' => true));

	// Register Navigation Menus
	register_nav_menu( 'primary', __('Main Navigation', 'dynamic-news-lite') );
	register_nav_menu( 'footer', __('Footer Navigation', 'dynamic-news-lite') );
	
	// Register Social Icons Menu
	register_nav_menu( 'social', __('Social Icons', 'dynamic-news-lite') );

}


// Add custom Image Sizes
add_action( 'after_setup_theme', 'dynamicnews_add_image_sizes' );

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


// Register Sidebars
add_action( 'widgets_init', 'dynamicnews_register_sidebars' );

function dynamicnews_register_sidebars() {

	// Register Sidebar
	register_sidebar( array(
		'name' => __( 'Sidebar', 'dynamic-news-lite' ),
		'id' => 'sidebar',
		'description' => __( 'Appears on posts and pages except Magazine Homepage and Fullwidth template.', 'dynamic-news-lite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle"><span>',
		'after_title' => '</span></h3>',
	));
	
	// Register Magazine Homepage
	register_sidebar( array(
		'name' => __( 'Magazine Homepage', 'dynamic-news-lite' ),
		'id' => 'frontpage-magazine',
		'description' => __( 'Appears on Magazine Homepage template only. You can use the Category Posts widgets here.', 'dynamic-news-lite' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	
}


/*==================================== INCLUDE FILES ====================================*/

// include Theme Info page
require( get_template_directory() . '/inc/theme-info.php' );

// include Theme Customizer Options
require( get_template_directory() . '/inc/customizer/customizer.php' );
require( get_template_directory() . '/inc/customizer/default-options.php' );

// include Customization Files
require( get_template_directory() . '/inc/customizer/frontend/custom-layout.php' );
require( get_template_directory() . '/inc/customizer/frontend/custom-slider.php' );

// Include Extra Functions
require get_template_directory() . '/inc/extras.php';

// include Template Functions
require( get_template_directory() . '/inc/template-tags.php' );

// Include support functions for Theme Addons
require get_template_directory() . '/inc/addons.php';

// include Widget Files
require( get_template_directory() . '/inc/widgets/widget-category-posts-boxed.php' );
require( get_template_directory() . '/inc/widgets/widget-category-posts-columns.php' );
require( get_template_directory() . '/inc/widgets/widget-category-posts-grid.php' );
require( get_template_directory() . '/inc/widgets/widget-category-posts-single.php' );

// Include Featured Content class
require( get_template_directory() . '/inc/featured-content.php' );