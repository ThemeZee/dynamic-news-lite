<?php
/**
 * Register PRO Version section, settings and controls for Theme Customizer
 *
 */

// Add Theme Colors section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_upgrade_settings' );

function dynamicnews_customize_register_upgrade_settings( $wp_customize ) {

	// Add Sections for Post Settings
	$wp_customize->add_section( 'dynamicnews_section_upgrade', array(
        'title'    => __( 'PRO Version', 'dynamicnewslite' ),
        'priority' => 70,
		'panel' => 'dynamicnews_options_panel' 
		)
	);

	// Add PRO Version Section
	$wp_customize->add_setting( 'dynamicnews_theme_options[pro_version_label]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
        $wp_customize, 'dynamicnews_control_pro_version_label', array(
            'label' => __( 'Need more features?', 'dynamicnewslite' ),
            'section' => 'dynamicnews_section_upgrade',
            'settings' => 'dynamicnews_theme_options[pro_version_label]',
            'priority' => 	1
            )
        )
    );
	$wp_customize->add_setting( 'dynamicnews_theme_options[pro_version]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control( new Dynamic_News_Customize_Text_Control(
        $wp_customize, 'dynamicnews_control_pro_version', array(
            'label' =>  __( 'Check out the PRO version which comes with additional features and advanced customization options.', 'dynamicnewslite' ),
            'section' => 'dynamicnews_section_upgrade',
            'settings' => 'dynamicnews_theme_options[pro_version]',
            'priority' => 	2
            )
        )
    );
	$wp_customize->add_setting( 'dynamicnews_theme_options[pro_version_button]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control( new Dynamic_News_Customize_Button_Control(
        $wp_customize, 'dynamicnews_control_pro_version_button', array(
            'label' => __('Learn more about the PRO Version', 'dynamicnewslite'),
			'section' => 'dynamicnews_section_upgrade',
            'settings' => 'dynamicnews_theme_options[pro_version_button]',
            'priority' => 	3
            )
        )
    );

}

?>