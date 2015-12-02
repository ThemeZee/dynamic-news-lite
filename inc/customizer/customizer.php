<?php
/**
 * Implement Theme Customizer
 *
 */

// Load Customizer Helper Functions
require( get_template_directory() . '/inc/customizer/functions/custom-controls.php' );
require( get_template_directory() . '/inc/customizer/functions/sanitize-functions.php' );

// Load Customizer sections
require( get_template_directory() . '/inc/customizer/sections/customizer-general.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-header.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-post.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-slider.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-upgrade.php' );


// Add Theme Options section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_options' );

function dynamicnews_customize_register_options( $wp_customize ) {

	// Add Theme Options Panel
	$wp_customize->add_panel( 'dynamicnews_options_panel', array(
		'priority'       => 180,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Theme Options', 'dynamic-news-lite' ),
		'description'    => '',
	) );

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	// Change default background section
	$wp_customize->get_control( 'background_color'  )->section   = 'background_image';
	$wp_customize->get_section( 'background_image'  )->title     = esc_html__( 'Background', 'dynamic-news-lite' );
	
	// Add Header Tagline option
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_tagline]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_header_tagline', array(
        'label'    => esc_html__( 'Display Tagline below site title.', 'dynamic-news-lite' ),
        'section'  => 'title_tagline',
        'settings' => 'dynamicnews_theme_options[header_tagline]',
        'type'     => 'checkbox',
		'priority' => 10
		)
	);
	
	// Add Header Image Link
	$wp_customize->add_setting( 'dynamicnews_theme_options[custom_header_link]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_custom_header_link', array(
        'label'    => esc_html__( 'Header Image Link', 'dynamic-news-lite' ),
        'section'  => 'header_image',
        'settings' => 'dynamicnews_theme_options[custom_header_link]',
        'type'     => 'url',
		'priority' => 10
		)
	);
	
	// Add Custom Header Hide Checkbox
	$wp_customize->add_setting( 'dynamicnews_theme_options[custom_header_hide]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_custom_header_hide', array(
        'label'    => esc_html__( 'Hide header image on front page', 'dynamic-news-lite' ),
        'section'  => 'header_image',
        'settings' => 'dynamicnews_theme_options[custom_header_hide]',
        'type'     => 'checkbox',
		'priority' => 15
		)
	);
	
}


// Embed JS file to make Theme Customizer preview reload changes asynchronously.
add_action( 'customize_preview_init', 'dynamicnews_customize_preview_js' );

function dynamicnews_customize_preview_js() {
	wp_enqueue_script( 'dynamicnewslite-customizer-preview', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151202', true );
}


// Embed JS file for Customizer Controls
add_action( 'customize_controls_enqueue_scripts', 'dynamicnews_customize_controls_js' );

function dynamicnews_customize_controls_js() {
	
	wp_enqueue_script( 'dynamicnewslite-customizer-controls', get_template_directory_uri() . '/js/customizer-controls.js', array(), '20151202', true );
	
	// Localize the script
	wp_localize_script( 'dynamicnewslite-customizer-controls', 'dynamicnews_theme_links', array(
		'title'	=> esc_html__( 'Theme Links', 'dynamic-news-lite' ),
		'themeURL'	=> esc_url( 'http://themezee.com/themes/dynamicnews/' ),
		'themeLabel'	=> esc_html__( 'Theme Page', 'dynamic-news-lite' ),
		'docuURL'	=> esc_url( 'http://themezee.com/docs/dynamicnews-documentation/' ),
		'docuLabel'	=>  esc_html__( 'Theme Documentation', 'dynamic-news-lite' ),
		'rateURL'	=> esc_url( 'http://wordpress.org/support/view/theme-reviews/dynamic-news-lite?filter=5' ),
		'rateLabel'	=> esc_html__( 'Rate this theme', 'dynamic-news-lite' ),
		)
	);

}


// Embed CSS styles for Theme Customizer
add_action( 'customize_controls_print_styles', 'dynamicnews_customize_preview_css' );

function dynamicnews_customize_preview_css() {
	wp_enqueue_style( 'dynamicnewslite-customizer-css', get_template_directory_uri() . '/css/customizer.css', array(), '20151202' );

}