<?php
/**
 * Implement Theme Customizer
 *
 */

// Load Customizer Helper Functions
require( get_template_directory() . '/inc/customizer/customizer-functions.php' );

// Load Customizer Settings
require( get_template_directory() . '/inc/customizer/customizer-colors.php' );
require( get_template_directory() . '/inc/customizer/customizer-fonts.php' );


// Add Theme Options section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_options' );

function dynamicnews_customize_register_options( $wp_customize ) {

	// Add Section for Theme Options
	$wp_customize->add_section( 'dynamicnews_section_options', array(
        'title'    => __( 'Theme Options', 'dynamicnews' ),
        'priority' => 180
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
        'label'    => __( 'Site Layout', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[layout]',
        'type'     => 'radio',
		'priority' => 1,
        'choices'  => array(
            'boxed' => __( 'Boxed Layout Width', 'dynamicnews' ),
            'wide' => __( 'Wide Layout (Fullwidth)', 'dynamicnews' )
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
        'label'    => __( 'Sidebar', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[sidebar]',
        'type'     => 'radio',
		'priority' => 2,
        'choices'  => array(
            'left-sidebar' => __( 'Left Sidebar', 'dynamicnews' ),
            'right-sidebar' => __( 'Right Sidebar', 'dynamicnews')
			)
		)
	);

	// Add Upload logo image setting
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_logo]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url'
		)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'dynamicnews_control_header_logo', array(
			'label'    => __( 'Logo Image (replaces Site Title)', 'dynamicnews' ),
			'section'  => 'dynamicnews_section_options',
			'settings' => 'dynamicnews_theme_options[header_logo]',
			'priority' => 3,
			)
		)
	);

	// Add Header Content Header
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_content]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
        $wp_customize, 'dynamicnews_control_header_content', array(
            'label' => __( 'Header Content', 'dynamicnews' ),
            'section' => 'dynamicnews_section_options',
            'settings' => 'dynamicnews_theme_options[header_content]',
            'priority' => 	4
            )
        )
    );
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_content_description]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control( new Dynamic_News_Customize_Description_Control(
        $wp_customize, 'dynamicnews_control_header_content_description', array(
            'label' =>  __( 'The Header Content configured below will be displayed on the right hand side of the header area.', 'dynamicnews' ),
            'section' => 'dynamicnews_section_options',
            'settings' => 'dynamicnews_theme_options[header_content_description]',
            'priority' => 	5
            )
        )
    );

	// Add Settings and Controls for Header
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_search]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_header_search', array(
        'label'    => __( 'Display search field on header area', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[header_search]',
        'type'     => 'checkbox',
		'priority' => 6
		)
	);

	$wp_customize->add_setting( 'dynamicnews_theme_options[header_icons]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_header_icons', array(
        'label'    => __( 'Display Social Icons on header area', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[header_icons]',
        'type'     => 'checkbox',
		'priority' => 7
		)
	);
	
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_text]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_header_text', array(
        'label'    => __( 'Header Text Line', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[header_text]',
        'type'     => 'text',
		'priority' => 8
		)
	);

	// Add Settings and Controls for Posts
	$wp_customize->add_setting( 'dynamicnews_theme_options[posts_length]', array(
        'default'           => 'index',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_post_length'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_posts_length', array(
        'label'    => __( 'Post Length on archives', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[posts_length]',
        'type'     => 'radio',
		'priority' => 9,
        'choices'  => array(
            'index' => __( 'Show full posts', 'dynamicnews' ),
            'excerpt' => __( 'Show post summaries (excerpt)', 'dynamicnews' )
			)
		)
	);

	$wp_customize->add_setting( 'dynamicnews_theme_options[post_thumbnails_index]', array(
        'default'           => true,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_posts_thumbnails_index', array(
        'label'    => __( 'Display featured images on archive pages', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[post_thumbnails_index]',
        'type'     => 'checkbox',
		'priority' => 10
		)
	);

	$wp_customize->add_setting( 'dynamicnews_theme_options[post_thumbnails_single]', array(
        'default'           => true,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_posts_thumbnails_single', array(
        'label'    => __( 'Display featured images on single posts', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[post_thumbnails_single]',
        'type'     => 'checkbox',
		'priority' => 11
		)
	);
	
	$wp_customize->add_setting( 'dynamicnews_theme_options[credit_link]', array(
        'default'           => true,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_credit_link', array(
        'label'    => __( 'Display Credit Link to ThemeZee on footer line.', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[credit_link]',
        'type'     => 'checkbox',
		'priority' => 12
		)
	);
	
	// Add settings and controls for Post Slider
	$wp_customize->add_setting( 'dynamicnews_theme_options[slider_activated]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
        $wp_customize, 'dynamicnews_control_slider_activated', array(
            'label' => __( 'Activate Featured Post Slider', 'dynamicnews' ),
            'section' => 'dynamicnews_section_options',
            'settings' => 'dynamicnews_theme_options[slider_activated]',
            'priority' => 	13
            )
        )
    );
	$wp_customize->add_setting( 'dynamicnews_theme_options[slider_activated_front_page]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_slider_activated_frontpage', array(
        'label'    => __( 'Display Slider on Magazine Front Page template.', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[slider_activated_front_page]',
        'type'     => 'checkbox',
		'priority' => 14
		)
	);
	$wp_customize->add_setting( 'dynamicnews_theme_options[slider_activated_blog]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_slider_activated_blog', array(
        'label'    => __( 'Display Slider on normal blog index.', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[slider_activated_blog]',
        'type'     => 'checkbox',
		'priority' => 15
		)
	);

	$wp_customize->add_setting( 'dynamicnews_theme_options[slider_animation]', array(
        'default'           => 'horizontal',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_slider_animation'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_slider_animation', array(
        'label'    => __( 'Slider Animation', 'dynamicnews' ),
        'section'  => 'dynamicnews_section_options',
        'settings' => 'dynamicnews_theme_options[slider_animation]',
        'type'     => 'radio',
		'priority' => 16,
        'choices'  => array(
            'horizontal' => __( 'Horizontal Slider', 'dynamicnews' ),
            'fade' => __( 'Fade Slider', 'dynamicnews' )
			)
		)
	);
	
	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	// Change default background section
	$wp_customize->get_control( 'background_color'  )->section   = 'background_image';
	$wp_customize->get_section( 'background_image'  )->title     = 'Background';
	
	// Add Header Tagline option
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_tagline]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_header_tagline', array(
        'label'    => __( 'Display Tagline below site title.', 'dynamicnews' ),
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
	wp_enqueue_script( 'dynamicnews-customizer-js', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20140312', true );
}


// Embed CSS styles for Theme Customizer
add_action( 'customize_controls_print_styles', 'dynamicnews_customize_preview_css' );

function dynamicnews_customize_preview_css() {
	wp_enqueue_style( 'dynamicnews-customizer-css', get_template_directory_uri() . '/css/customizer.css', array(), '20140312' );

}



?>