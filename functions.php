<?php

/*==================================== THEME SETUP ====================================*/

// Load default style.css and Javascripts
add_action( 'wp_enqueue_scripts', 'dynamicnews_enqueue_scripts' );

function dynamicnews_enqueue_scripts() {

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Get Theme Version
	$theme_version = wp_get_theme()->get( 'Version' );

	// Register and Enqueue Stylesheet
	wp_enqueue_style( 'dynamicnewslite-stylesheet', get_stylesheet_uri(), array(), $theme_version );

	// Register Genericons
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/css/genericons/genericons.css', array(), '3.4.1' );

	// Register and Enqueue HTML5shiv to support HTML5 elements in older IE versions
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.min.js', array(), '3.7.3' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	// Register and Enqueue FlexSlider JS and CSS if necessary
	if ( ( isset( $theme_options['slider_activated_blog'] ) and true == $theme_options['slider_activated_blog'] )
		|| ( isset( $theme_options['slider_activated_front_page'] ) and true == $theme_options['slider_activated_front_page'] ) ) :

		// FlexSlider CSS
		wp_enqueue_style( 'dynamicnewslite-flexslider', get_template_directory_uri() . '/css/flexslider.css' );

		// FlexSlider JS
		wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '2.6.0' );

		// Register and enqueue slider.js
		wp_enqueue_script( 'dynamicnewslite-jquery-frontpage_slider', get_template_directory_uri() . '/js/slider.js', array( 'flexslider' ), '2.6.0' );

	endif;

	// Register and enqueue navigation.js
	wp_enqueue_script( 'dynamicnewslite-jquery-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20160719' );

	// Passing Parameters to Navigation.js Javascript
	wp_localize_script( 'dynamicnewslite-jquery-navigation', 'dynamicnews_menu_title', esc_html__( 'Menu', 'dynamic-news-lite' ) );

	// Register and enqueue sidebar.js
	if ( true == $theme_options['sliding_sidebar'] ) {

		wp_enqueue_script( 'dynamicnewslite-jquery-sidebar', get_template_directory_uri() . '/js/sidebar.js', array( 'jquery' ), '20160421' );
		wp_localize_script( 'dynamicnewslite-jquery-sidebar', 'dynamicnews_sidebar_title', esc_html__( 'Sidebar', 'dynamic-news-lite' ) );

	}

	// Register Comment Reply Script for Threaded Comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}


/**
 * Enqueue custom fonts.
 */
function dynamicnews_custom_fonts() {
	wp_enqueue_style( 'dynamicnews-custom-fonts', get_template_directory_uri() . '/css/custom-fonts.css', array(), '20180413' );
}
add_action( 'wp_enqueue_scripts', 'dynamicnews_custom_fonts', 1 );
add_action( 'enqueue_block_editor_assets', 'dynamicnews_custom_fonts', 1 );


/**
 * Enqueue editor styles for the new Gutenberg Editor.
 */
function dynamicnews_block_editor_assets() {
	wp_enqueue_style( 'dynamicnews-editor-styles', get_template_directory_uri() . '/css/gutenberg-styles.css', array(), '20181102', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'dynamicnews_block_editor_assets' );


// Setup Function: Registers support for various WordPress features
add_action( 'after_setup_theme', 'dynamicnews_setup' );

function dynamicnews_setup() {

	// Set Content Width
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 860;
	}

	// init Localization
	load_theme_textdomain( 'dynamic-news-lite', get_template_directory() . '/languages' );

	// Add Theme Support
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_editor_style();

	// Add Custom Background
	add_theme_support( 'custom-background', array( 'default-color' => 'e5e5e5' ) );

	// Set up the WordPress core custom logo feature
	add_theme_support( 'custom-logo', apply_filters( 'dynamicnews_custom_logo_args', array(
		'height'      => 50,
		'width'       => 350,
		'flex-height' => true,
		'flex-width'  => true,
	) ) );

	// Add Custom Header
	add_theme_support( 'custom-header', array(
		'header-text' => false,
		'width'       => 1340,
		'height'      => 200,
		'flex-height' => true,
	) );

	// Add Theme Support for wooCommerce
	add_theme_support( 'woocommerce' );

	// Register Navigation Menus
	register_nav_menu( 'primary', esc_html__( 'Main Navigation', 'dynamic-news-lite' ) );
	register_nav_menu( 'secondary', esc_html__( 'Top Navigation', 'dynamic-news-lite' ) );
	register_nav_menu( 'footer', esc_html__( 'Footer Navigation', 'dynamic-news-lite' ) );

	// Register Social Icons Menu
	register_nav_menu( 'social', esc_html__( 'Social Icons', 'dynamic-news-lite' ) );

	// Add Theme Support for Selective Refresh in Customizer
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add custom color palette for Gutenberg.
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => esc_html_x( 'Primary', 'Gutenberg Color Palette', 'dynamic-news-lite' ),
			'slug'  => 'primary',
			'color' => apply_filters( 'dynamicnews_primary_color', '#e84747' ),
		),
		array(
			'name'  => esc_html_x( 'White', 'Gutenberg Color Palette', 'dynamic-news-lite' ),
			'slug'  => 'white',
			'color' => '#ffffff',
		),
		array(
			'name'  => esc_html_x( 'Light Gray', 'Gutenberg Color Palette', 'dynamic-news-lite' ),
			'slug'  => 'light-gray',
			'color' => '#f0f0f0',
		),
		array(
			'name'  => esc_html_x( 'Dark Gray', 'Gutenberg Color Palette', 'dynamic-news-lite' ),
			'slug'  => 'dark-gray',
			'color' => '#777777',
		),
		array(
			'name'  => esc_html_x( 'Black', 'Gutenberg Color Palette', 'dynamic-news-lite' ),
			'slug'  => 'black',
			'color' => '#353535',
		),
	) );
}


// Add custom Image Sizes
add_action( 'after_setup_theme', 'dynamicnews_add_image_sizes' );

function dynamicnews_add_image_sizes() {

	// Add Custom Header Image Size
	add_image_size( 'custom_header_image', 1340, 200, true );

	// Add Featured Image Size
	add_image_size( 'featured_image', 860, 280, true );

	// Add Slider Image Size
	add_image_size( 'slider_image', 880, 290, true );

	// Add Frontpage Thumbnail Sizes
	add_image_size( 'category_posts_wide_thumb', 420, 140, true );
	add_image_size( 'category_posts_small_thumb', 90, 90, true );

	// Add Widget Post Thumbnail Size
	add_image_size( 'widget_post_thumb', 75, 75, true );
}


// Register Sidebars
add_action( 'widgets_init', 'dynamicnews_register_sidebars' );

function dynamicnews_register_sidebars() {

	// Register Sidebar
	register_sidebar( array(
		'name' => esc_html__( 'Sidebar', 'dynamic-news-lite' ),
		'id' => 'sidebar',
		'description' => esc_html__( 'Appears on posts and pages except the full width template.', 'dynamic-news-lite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle"><span>',
		'after_title' => '</span></h3>',
	));

	// Register Header Widgets
	register_sidebar( array(
		'name' => esc_html__( 'Header', 'dynamic-news-lite' ),
		'id' => 'header',
		'description' => esc_html__( 'Appears on header area. You can use a search or ad widget here.', 'dynamic-news-lite' ),
		'before_widget' => '<aside id="%1$s" class="header-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="header-widget-title">',
		'after_title' => '</h4>',
	));

	// Register Magazine Homepage
	register_sidebar( array(
		'name' => esc_html__( 'Magazine Homepage', 'dynamic-news-lite' ),
		'id' => 'frontpage-magazine',
		'description' => esc_html__( 'Appears on Magazine Homepage template only. You can use the Category Posts widgets here.', 'dynamic-news-lite' ),
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
