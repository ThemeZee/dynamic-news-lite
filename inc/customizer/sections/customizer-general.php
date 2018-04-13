<?php
/**
 * Register General section, settings and controls for Theme Customizer
 *
 */

// Add Theme Colors section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_general_settings' );

function dynamicnews_customize_register_general_settings( $wp_customize ) {

	// Add Section for Theme Options
	$wp_customize->add_section( 'dynamicnews_section_general', array(
		'title'    => esc_html__( 'General Settings', 'dynamic-news-lite' ),
		'priority' => 10,
		'panel' => 'dynamicnews_options_panel',
		)
	);

	// Add Settings and Controls for Layout
	$wp_customize->add_setting( 'dynamicnews_theme_options[layout]', array(
		'default'           => 'boxed',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_layout',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_layout', array(
		'label'    => esc_html__( 'Theme Design', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_general',
		'settings' => 'dynamicnews_theme_options[layout]',
		'type'     => 'radio',
		'priority' => 1,
		'choices'  => array(
			'boxed' => esc_html__( 'Boxed Layout', 'dynamic-news-lite' ),
			'wide' => esc_html__( 'Wide Layout (Fullwidth)', 'dynamic-news-lite' ),
			'flat' => esc_html__( 'Flat Layout', 'dynamic-news-lite' ),
		),
	) );

	$wp_customize->add_setting( 'dynamicnews_theme_options[sidebar]', array(
		'default'           => 'right-sidebar',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_sidebar',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_sidebar', array(
		'label'    => esc_html__( 'Sidebar Layout', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_general',
		'settings' => 'dynamicnews_theme_options[sidebar]',
		'type'     => 'radio',
		'priority' => 2,
		'choices'  => array(
			'left-sidebar' => esc_html__( 'Left Sidebar', 'dynamic-news-lite' ),
			'right-sidebar' => esc_html__( 'Right Sidebar', 'dynamic-news-lite' ),
		),
	) );

	// Add Sliding Sidebar Header
	$wp_customize->add_setting( 'dynamicnews_theme_options[sliding_sidebar_title]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
		$wp_customize, 'dynamicnews_control_sliding_sidebar_title', array(
			'label' => esc_html__( 'Sliding Sidebar', 'dynamic-news-lite' ),
			'section' => 'dynamicnews_section_general',
			'settings' => 'dynamicnews_theme_options[sliding_sidebar_title]',
			'priority' => 5,
		)
	) );

	// Add Sliding Sidbar checkbox
	$wp_customize->add_setting( 'dynamicnews_theme_options[sliding_sidebar]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_sliding_sidebar', array(
		'label'    => esc_html__( 'Display Sliding Sidebar on mobile screens', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_general',
		'settings' => 'dynamicnews_theme_options[sliding_sidebar]',
		'type'     => 'checkbox',
		'priority' => 6,
		)
	);

}
