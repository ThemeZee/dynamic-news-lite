<?php
/**
 * Register Post Settings section, settings and controls for Theme Customizer
 *
 */

// Add Theme Colors section to Customizer
add_action( 'customize_register', 'dynamicnews_customize_register_post_settings' );

function dynamicnews_customize_register_post_settings( $wp_customize ) {

	// Add Sections for Post Settings
	$wp_customize->add_section( 'dynamicnews_section_post', array(
        'title'    => __( 'Post Settings', 'dynamic-news-lite' ),
        'priority' => 30,
		'panel' => 'dynamicnews_options_panel' 
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
        'label'    => __( 'Post length on archives', 'dynamic-news-lite' ),
        'section'  => 'dynamicnews_section_post',
        'settings' => 'dynamicnews_theme_options[posts_length]',
        'type'     => 'radio',
		'priority' => 1,
        'choices'  => array(
            'index' => __( 'Show full posts', 'dynamic-news-lite' ),
            'excerpt' => __( 'Show post excerpts', 'dynamic-news-lite' )
			)
		)
	);
	
	// Add Setting and Control for Excerpt Length
	$wp_customize->add_setting( 'dynamicnews_theme_options[excerpt_length]', array(
        'default'           => 60,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_excerpt_length', array(
        'label'    => __( 'Excerpt Length', 'dynamic-news-lite' ),
        'section'  => 'dynamicnews_section_post',
        'settings' => 'dynamicnews_theme_options[excerpt_length]',
        'type'     => 'text',
		'active_callback' => 'dynamicnews_control_posts_length_callback',
		'priority' => 2
		)
	);
	
	// Add Excerpt Text setting
	$wp_customize->add_setting( 'dynamicnews_theme_options[excerpt_text_headline]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
        $wp_customize, 'dynamicnews_control_excerpt_text_headline', array(
            'label' => __( 'Text after Excerpts', 'dynamic-news-lite' ),
            'section' => 'dynamicnews_section_post',
            'settings' => 'dynamicnews_theme_options[excerpt_text_headline]',
            'priority' => 3
            )
        )
    );
	$wp_customize->add_setting( 'dynamicnews_theme_options[excerpt_text]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_excerpt_text', array(
        'label'    => __( 'Display [...] after excerpts', 'dynamic-news-lite' ),
        'section'  => 'dynamicnews_section_post',
        'settings' => 'dynamicnews_theme_options[excerpt_text]',
        'type'     => 'checkbox',
		'priority' => 4
		)
	);
	
	// Add Post Images Headline
	$wp_customize->add_setting( 'dynamicnews_theme_options[post_images]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
        $wp_customize, 'dynamicnews_control_post_images', array(
            'label' => __( 'Post Images', 'dynamic-news-lite' ),
            'section' => 'dynamicnews_section_post',
            'settings' => 'dynamicnews_theme_options[post_images]',
            'priority' => 5
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
        'label'    => __( 'Display featured images on archive pages', 'dynamic-news-lite' ),
        'section'  => 'dynamicnews_section_post',
        'settings' => 'dynamicnews_theme_options[post_thumbnails_index]',
        'type'     => 'checkbox',
		'priority' => 6
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
        'label'    => __( 'Display featured images on single posts', 'dynamic-news-lite' ),
        'section'  => 'dynamicnews_section_post',
        'settings' => 'dynamicnews_theme_options[post_thumbnails_single]',
        'type'     => 'checkbox',
		'priority' => 7
		)
	);
	
	// Add Post Meta Settings
	$wp_customize->add_setting( 'dynamicnews_theme_options[postmeta_headline]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Dynamic_News_Customize_Header_Control(
        $wp_customize, 'dynamicnews_control_postmeta_headline', array(
            'label' => __( 'Post Meta', 'dynamic-news-lite' ),
            'section' => 'dynamicnews_section_post',
            'settings' => 'dynamicnews_theme_options[postmeta_headline]',
            'priority' => 8
            )
        )
    );
	$wp_customize->add_setting( 'dynamicnews_theme_options[meta_date]', array(
        'default'           => true,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_meta_date', array(
        'label'    => __( 'Display post date', 'dynamic-news-lite' ),
        'section'  => 'dynamicnews_section_post',
        'settings' => 'dynamicnews_theme_options[meta_date]',
        'type'     => 'checkbox',
		'priority' => 9
		)
	);
	$wp_customize->add_setting( 'dynamicnews_theme_options[meta_author]', array(
        'default'           => true,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_meta_author', array(
        'label'    => __( 'Display post author', 'dynamic-news-lite' ),
        'section'  => 'dynamicnews_section_post',
        'settings' => 'dynamicnews_theme_options[meta_author]',
        'type'     => 'checkbox',
		'priority' => 10
		)
	);
	$wp_customize->add_setting( 'dynamicnews_theme_options[meta_category]', array(
        'default'           => true,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_meta_category', array(
        'label'    => __( 'Display post categories', 'dynamic-news-lite' ),
        'section'  => 'dynamicnews_section_post',
        'settings' => 'dynamicnews_theme_options[meta_category]',
        'type'     => 'checkbox',
		'priority' => 11
		)
	);
	$wp_customize->add_setting( 'dynamicnews_theme_options[meta_tags]', array(
        'default'           => true,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'dynamicnews_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'dynamicnews_control_meta_tags', array(
        'label'    => __( 'Display post tags', 'dynamic-news-lite' ),
        'section'  => 'dynamicnews_section_post',
        'settings' => 'dynamicnews_theme_options[meta_tags]',
        'type'     => 'checkbox',
		'priority' => 12
		)
	);

}

?>