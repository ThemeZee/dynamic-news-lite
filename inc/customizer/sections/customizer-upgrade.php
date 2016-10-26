<?php
/**
 * Register upgrade section, settings and controls for Theme Customizer
 *
 */

// Add Theme Colors section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_upgrade_settings' );

function dynamicnews_customize_register_upgrade_settings( $wp_customize ) {

	// Add Upgrade / More Features Section
	$wp_customize->add_section( 'dynamicnews_section_upgrade', array(
		'title'    => esc_html__( 'More Features', 'dynamic-news-lite' ),
		'priority' => 70,
		'panel' => 'dynamicnews_options_panel',
		)
	);

	// Add custom Upgrade Content control
	$wp_customize->add_setting( 'dynamicnews_theme_options[upgrade]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Dynamic_News_Customize_Upgrade_Control(
		$wp_customize, 'dynamicnews_control_upgrade', array(
			'section' => 'dynamicnews_section_upgrade',
			'settings' => 'dynamicnews_theme_options[upgrade]',
			'priority' => 1,
		)
	) );

}
