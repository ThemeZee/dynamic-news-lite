<?php 
/***
 * Custom Javascript Options
 *
 * Passing Variables from custom Theme Options to the javascript files
 * of theme navigation and frontpage slider. 
 *
 */

// Passing Variables to Theme Navigation ( js/navigation.js)
add_action('wp_enqueue_scripts', 'dynamicnews_custom_jscript_navigation');

if ( ! function_exists( 'dynamicnews_custom_jscript_navigation' ) ):
function dynamicnews_custom_jscript_navigation() { 

	// Set Parameters array
	$params = array(
		'menuTitle' => __('Menu', 'dynamicnewslite')
	);
	
	// Passing Parameters to Javascript
	wp_localize_script( 'dynamicnewslite-jquery-navigation', 'dynamicnews_navigation_params', $params );
}
endif;


// Passing Variables to Frontpage Slider ( js/slider.js)
add_action('wp_enqueue_scripts', 'dynamicnews_custom_jscript_slider');

if ( ! function_exists( 'dynamicnews_custom_jscript_slider' ) ):
function dynamicnews_custom_jscript_slider() { 
	
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Set Parameters array
	$params = array();
	
	// Define Slider Animation
	if( isset($theme_options['slider_animation']) ) :
		$params['animation'] = esc_attr($theme_options['slider_animation']);
	endif;
	
	// Passing Parameters to Javascript
	wp_localize_script( 'dynamicnewslite-jquery-frontpage_slider', 'dynamicnews_slider_params', $params );
}
endif;


?>