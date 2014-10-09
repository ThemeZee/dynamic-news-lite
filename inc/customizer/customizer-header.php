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
        'title'    => __( 'Header Content', 'dynamicnewslite' ),
        'priority' => 20,
		'panel' => 'dynamicnews_options_panel' 
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
            'label' => __( 'Header Content', 'dynamicnewslite' ),
            'section' => 'dynamicnews_section_header',
            'settings' => 'dynamicnews_theme_options[header_content]',
            'priority' => 1
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
            'label' =>  __( 'The Header Content configured below will be displayed on the right hand side of the header area.', 'dynamicnewslite' ),
            'section' => 'dynamicnews_section_header',
            'settings' => 'dynamicnews_theme_options[header_content_description]',
            'priority' => 2
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
        'label'    => __( 'Display search field on header area', 'dynamicnewslite' ),
        'section'  => 'dynamicnews_section_header',
        'settings' => 'dynamicnews_theme_options[header_search]',
        'type'     => 'checkbox',
		'priority' => 3
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
        'label'    => __( 'Display Social Icons on header area', 'dynamicnewslite' ),
        'section'  => 'dynamicnews_section_header',
        'settings' => 'dynamicnews_theme_options[header_icons]',
        'type'     => 'checkbox',
		'priority' => 4
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
        'label'    => __( 'Header Text Line', 'dynamicnewslite' ),
        'section'  => 'dynamicnews_section_header',
        'settings' => 'dynamicnews_theme_options[header_text]',
        'type'     => 'text',
		'priority' => 5
		)
	);
	
}

?>