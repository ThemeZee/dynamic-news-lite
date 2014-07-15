<?php
/**
 * Register Theme Font section, settings and controls for Theme Customizer
 *
 */

// Add Theme Fonts section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_fonts' );

function dynamicnews_customize_register_fonts( $wp_customize ) {

	// Add Section for Theme Fonts
	$wp_customize->add_section( 'dynamicnews_section_fonts', array(
        'title'    => __( 'Theme Fonts', 'dynamicnews' ),
        'priority' => 160
		)
	);

	// Add settings and controls for theme fonts
	$wp_customize->add_setting( 'dynamicnews_theme_options[text_font]', array(
        'default'           => 'Droid Sans',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => ''
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Font_Control( 
		$wp_customize, 'text_font', array(
			'label'      => __( 'Default Text Font', 'dynamicnews' ),
			'section'    => 'dynamicnews_section_fonts',
			'settings'   => 'dynamicnews_theme_options[text_font]',
			'priority' => 1
		) ) 
	);
	
	$wp_customize->add_setting( 'dynamicnews_theme_options[title_font]', array(
        'default'           => 'Francois One',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => ''
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Font_Control( 
		$wp_customize, 'title_font', array(
			'label'      => __( 'Title Font', 'dynamicnews' ),
			'section'    => 'dynamicnews_section_fonts',
			'settings'   => 'dynamicnews_theme_options[title_font]',
			'priority' => 1
		) ) 
	);
	
	$wp_customize->add_setting( 'dynamicnews_theme_options[navi_font]', array(
        'default'           => 'Francois One',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => ''
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Font_Control( 
		$wp_customize, 'navi_font', array(
			'label'      => __( 'Navigation Font', 'dynamicnews' ),
			'section'    => 'dynamicnews_section_fonts',
			'settings'   => 'dynamicnews_theme_options[navi_font]',
			'priority' => 1
		) ) 
	);
	
	$wp_customize->add_setting( 'dynamicnews_theme_options[widget_title_font]', array(
        'default'           => 'Droid Sans',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => ''
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Font_Control( 
		$wp_customize, 'widget_title_font', array(
			'label'      => __( 'Widget Title Font', 'dynamicnews' ),
			'section'    => 'dynamicnews_section_fonts',
			'settings'   => 'dynamicnews_theme_options[widget_title_font]',
			'priority' => 1
		) ) 
	);
	
}


?>