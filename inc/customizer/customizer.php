<?php
/**
 * Implement Theme Customizer
 *
 */

// Load Customizer Helper Functions
require( get_template_directory() . '/inc/customizer/customizer-functions.php' );

// Load Customizer Settings
require( get_template_directory() . '/inc/customizer/customizer-header.php' );
require( get_template_directory() . '/inc/customizer/customizer-post.php' );
require( get_template_directory() . '/inc/customizer/customizer-slider.php' );
require( get_template_directory() . '/inc/customizer/customizer-upgrade.php' );


// Add Theme Options section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_options' );

function dynamicnews_customize_register_options( $wp_customize ) {

	// Add Theme Options Panel
	$wp_customize->add_panel( 'dynamicnews_options_panel', array(
		'priority'       => 180,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'Theme Options', 'dynamicnewslite' ),
		'description'    => '',
	) );

	// Add Section for Theme Options
	$wp_customize->add_section( 'dynamicnews_section_general', array(
        'title'    => __( 'General Settings', 'dynamicnewslite' ),
        'priority' => 10,
		'panel' => 'dynamicnews_options_panel' 
		)
	);
	
	// Add Settings and Controls for Layout
	$wp_customize->add_setting( 'dynamicnews_theme_options[layout]', array(
        'default'           => 'boxed',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_layout'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_layout', array(
        'label'    => __( 'Site Layout', 'dynamicnewslite' ),
        'section'  => 'dynamicnews_section_general',
        'settings' => 'dynamicnews_theme_options[layout]',
        'type'     => 'radio',
		'priority' => 1,
        'choices'  => array(
            'boxed' => __( 'Boxed Layout Width', 'dynamicnewslite' ),
            'wide' => __( 'Wide Layout (Fullwidth)', 'dynamicnewslite' )
			)
		)
	);
	
	$wp_customize->add_setting( 'dynamicnews_theme_options[sidebar]', array(
        'default'           => 'right-sidebar',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_sidebar'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_sidebar', array(
        'label'    => __( 'Sidebar', 'dynamicnewslite' ),
        'section'  => 'dynamicnews_section_general',
        'settings' => 'dynamicnews_theme_options[sidebar]',
        'type'     => 'radio',
		'priority' => 2,
        'choices'  => array(
            'left-sidebar' => __( 'Left Sidebar', 'dynamicnewslite' ),
            'right-sidebar' => __( 'Right Sidebar', 'dynamicnewslite')
			)
		)
	);
	
	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	// Change default background section
	$wp_customize->get_control( 'background_color'  )->section   = 'background_image';
	$wp_customize->get_section( 'background_image'  )->title     = 'Background';
	
	// Change Featured Content Section
	$wp_customize->get_section( 'featured_content'  )->panel = 'dynamicnews_options_panel';
	$wp_customize->get_section( 'featured_content'  )->priority = 40;
	
	// Add Header Tagline option
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_tagline]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_header_tagline', array(
        'label'    => __( 'Display Tagline below site title.', 'dynamicnewslite' ),
        'section'  => 'title_tagline',
        'settings' => 'dynamicnews_theme_options[header_tagline]',
        'type'     => 'checkbox',
		'priority' => 99
		)
	);
	
}


// Embed JS file to make Theme Customizer preview reload changes asynchronously.
add_action( 'customize_preview_init', 'dynamicnews_customize_preview_js' );

function dynamicnews_customize_preview_js() {
	wp_enqueue_script( 'dynamicnewslite-customizer-js', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20140312', true );
}


// Embed CSS styles for Theme Customizer
add_action( 'customize_controls_print_styles', 'dynamicnews_customize_preview_css' );

function dynamicnews_customize_preview_css() {
	wp_enqueue_style( 'dynamicnewslite-customizer-css', get_template_directory_uri() . '/css/customizer.css', array(), '20140312' );

}

?>