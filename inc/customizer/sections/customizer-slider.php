<?php
/**
 * Register Post Slider section, settings and controls for Theme Customizer
 *
 */

// Add Theme Colors section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_slider_settings' );

function dynamicnews_customize_register_slider_settings( $wp_customize ) {

	// Add Sections for Slider Settings
	$wp_customize->add_section( 'dynamicnews_section_slider', array(
		'title'    => esc_html__( 'Post Slider', 'dynamic-news-lite' ),
		'priority' => 50,
		'panel' => 'dynamicnews_options_panel',
		)
	);

	// Add settings and controls for Post Slider
	$wp_customize->add_setting( 'dynamicnews_theme_options[slider_activated]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
		$wp_customize, 'dynamicnews_control_slider_activated', array(
			'label' => esc_html__( 'Activate Post Slider', 'dynamic-news-lite' ),
			'section' => 'dynamicnews_section_slider',
			'settings' => 'dynamicnews_theme_options[slider_activated]',
			'priority' => 1,
		)
	) );
	$wp_customize->add_setting( 'dynamicnews_theme_options[slider_activated_front_page]', array(
		'default'           => false,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_slider_activated_frontpage', array(
		'label'    => esc_html__( 'Show Slider on Magazine Homepage', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_slider',
		'settings' => 'dynamicnews_theme_options[slider_activated_front_page]',
		'type'     => 'checkbox',
		'priority' => 2,
		)
	);
	$wp_customize->add_setting( 'dynamicnews_theme_options[slider_activated_blog]', array(
		'default'           => false,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_slider_activated_blog', array(
		'label'    => esc_html__( 'Show Slider on posts page', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_slider',
		'settings' => 'dynamicnews_theme_options[slider_activated_blog]',
		'type'     => 'checkbox',
		'priority' => 3,
		)
	);

	// Select Featured Posts
	$wp_customize->add_setting( 'dynamicnews_theme_options[featured_posts_header]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
		$wp_customize, 'dynamicnews_control_featured_posts_header', array(
			'label' => esc_html__( 'Select Featured Posts', 'dynamic-news-lite' ),
			'section' => 'dynamicnews_section_slider',
			'settings' => 'dynamicnews_theme_options[featured_posts_header]',
			'priority' => 3,
			'active_callback' => 'dynamicnews_slider_activated_callback',
		)
	) );
	$wp_customize->add_setting( 'dynamicnews_theme_options[featured_posts_description]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Description_Control(
		$wp_customize, 'dynamicnews_control_featured_posts_description', array(
			'label'    => esc_html__( 'The slideshow displays all your featured posts. You can easily feature posts by a tag of your choice.', 'dynamic-news-lite' ),
			'section' => 'dynamicnews_section_slider',
			'settings' => 'dynamicnews_theme_options[featured_posts_description]',
			'priority' => 4,
			'active_callback' => 'dynamicnews_slider_activated_callback',
		)
	) );

	// Add Slider Animation Setting
	$wp_customize->add_setting( 'dynamicnews_theme_options[slider_animation]', array(
		'default'           => 'slide',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_slider_animation',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_slider_animation', array(
		'label'    => esc_html__( 'Slider Animation', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_slider',
		'settings' => 'dynamicnews_theme_options[slider_animation]',
		'type'     => 'radio',
		'priority' => 8,
		'active_callback' => 'dynamicnews_slider_activated_callback',
		'choices'  => array(
			'slide' => esc_html__( 'Slide Effect', 'dynamic-news-lite' ),
			'fade' => esc_html__( 'Fade Effect', 'dynamic-news-lite' ),
		),
	) );

	// Add Setting and Control for Slider Speed
	$wp_customize->add_setting( 'dynamicnews_theme_options[slider_speed]', array(
		'default'           => 7000,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control( 'dynamicnews_theme_options[slider_speed]', array(
		'label'    => esc_html__( 'Slider Speed (in ms)', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_slider',
		'settings' => 'dynamicnews_theme_options[slider_speed]',
		'type'     => 'number',
		'active_callback' => 'dynamicnews_slider_activated_callback',
		'priority' => 9,
		'input_attrs' => array(
			'min'   => 1000,
			'step'  => 100,
		),
	) );

}
