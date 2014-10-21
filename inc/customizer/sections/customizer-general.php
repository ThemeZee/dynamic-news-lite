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
	
}


?>