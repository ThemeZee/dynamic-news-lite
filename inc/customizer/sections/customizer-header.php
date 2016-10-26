<?php
/**
 * Register Header Content section, settings and controls for Theme Customizer
 *
 */

// Add Theme Colors section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_header_settings' );

function dynamicnews_customize_register_header_settings( $wp_customize ) {

	// Add Sections for Header Content
	$wp_customize->add_section( 'dynamicnews_section_header', array(
		'title'    => esc_html__( 'Header Settings', 'dynamic-news-lite' ),
		'priority' => 20,
		'panel' => 'dynamicnews_options_panel',
		)
	);

	// Add Header Content Header
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_content]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
		$wp_customize, 'dynamicnews_control_header_content', array(
			'label' => esc_html__( 'Header Content', 'dynamic-news-lite' ),
			'section' => 'dynamicnews_section_header',
			'settings' => 'dynamicnews_theme_options[header_content]',
			'priority' => 3,
		)
	) );
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_content_description]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Description_Control(
		$wp_customize, 'dynamicnews_control_header_content_description', array(
			'label' => esc_html__( 'The Header Content will be displayed on the right hand side of the header area.', 'dynamic-news-lite' ),
			'section' => 'dynamicnews_section_header',
			'settings' => 'dynamicnews_theme_options[header_content_description]',
			'priority' => 4,
		)
	) );

	// Add Settings and Controls for Header
	$wp_customize->add_setting( 'dynamicnews_theme_options[header_search]', array(
		'default'           => false,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_header_search', array(
		'label'    => esc_html__( 'Display search field on header area', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_header',
		'settings' => 'dynamicnews_theme_options[header_search]',
		'type'     => 'checkbox',
		'priority' => 5,
		)
	);

	$wp_customize->add_setting( 'dynamicnews_theme_options[header_icons]', array(
		'default'           => false,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_header_icons', array(
		'label'    => esc_html__( 'Display Social Icons on header area', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_header',
		'settings' => 'dynamicnews_theme_options[header_icons]',
		'type'     => 'checkbox',
		'priority' => 6,
		)
	);

	$wp_customize->add_setting( 'dynamicnews_theme_options[header_text]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_header_text', array(
		'label'    => esc_html__( 'Header Text Line', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_header',
		'settings' => 'dynamicnews_theme_options[header_text]',
		'type'     => 'text',
		'priority' => 7,
		)
	);

	// Add Settings and Controls for Mobile Header
	$wp_customize->add_setting( 'dynamicnews_theme_options[mobile_header]', array(
		'default'           => 'none',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_mobile_header',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_mobile_header', array(
		'label'    => esc_html__( 'Header Content on small screens', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_header',
		'settings' => 'dynamicnews_theme_options[mobile_header]',
		'type'     => 'select',
		'priority' => 8,
		'choices'  => array(
			'none' => esc_html__( 'Display no content on small screens', 'dynamic-news-lite' ),
			'social' => esc_html__( 'Display social icons on small screens', 'dynamic-news-lite' ),
			'search' => esc_html__( 'Display search field on small screens', 'dynamic-news-lite' ),
			'text' => esc_html__( 'Display header text on small screens', 'dynamic-news-lite' ),
			'widgets' => esc_html__( 'Display header widgets on small screens', 'dynamic-news-lite' ),
		),
	) );

	$wp_customize->add_setting( 'dynamicnews_theme_options[topnavi_title]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
		$wp_customize, 'dynamicnews_control_topnavi_title', array(
			'label' => esc_html__( 'Top Navigation', 'dynamic-news-lite' ),
			'section' => 'dynamicnews_section_header',
			'settings' => 'dynamicnews_theme_options[topnavi_title]',
			'priority' => 9,
		)
	) );

	$wp_customize->add_setting( 'dynamicnews_theme_options[topnavi_icons]', array(
		'default'           => false,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'dynamicnews_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'dynamicnews_control_topnavi_icons', array(
		'label'    => esc_html__( 'Display Social Icons on top navigation', 'dynamic-news-lite' ),
		'section'  => 'dynamicnews_section_header',
		'settings' => 'dynamicnews_theme_options[topnavi_icons]',
		'type'     => 'checkbox',
		'priority' => 10,
		)
	);

}
