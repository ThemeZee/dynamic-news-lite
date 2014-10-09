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
        'title'    => __( 'Post Slider', 'dynamicnewslite' ),
		'description' => __( 'The slideshow displays your featured posts, which you can configure on the "Featured Content" section above.', 'dynamicnewslite' ),
        'priority' => 50,
		'panel' => 'dynamicnews_options_panel' 
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
            'label' => __( 'Activate Featured Post Slider', 'dynamicnewslite' ),
            'section' => 'dynamicnews_section_slider',
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
        'label'    => __( 'Display Slider on Magazine Front Page template.', 'dynamicnewslite' ),
        'section'  => 'dynamicnews_section_slider',
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
        'label'    => __( 'Display Slider on normal blog index.', 'dynamicnewslite' ),
        'section'  => 'dynamicnews_section_slider',
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
        'label'    => __( 'Slider Animation', 'dynamicnewslite' ),
        'section'  => 'dynamicnews_section_slider',
        'settings' => 'dynamicnews_theme_options[slider_animation]',
        'type'     => 'radio',
		'priority' => 16,
        'choices'  => array(
            'horizontal' => __( 'Horizontal Slider', 'dynamicnewslite' ),
            'fade' => __( 'Fade Slider', 'dynamicnewslite' )
			)
		)
	);
	
}

?>