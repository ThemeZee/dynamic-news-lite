<?php 
/***
 * Custom Slider Parameters
 *
 * Passing Variables from custom Theme Options to the javascript files
 * of featured content slider. 
 *
 */

// Passing Variables to Featured Content Slider ( js/slider.js)
add_action('wp_enqueue_scripts', 'dynamicnews_custom_slider_parameter');

if ( ! function_exists( 'dynamicnews_custom_slider_parameter' ) ):
function dynamicnews_custom_slider_parameter() { 
	
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Set Parameters array
	$params = array();
	
	// Define Slider Animation
	if( isset($theme_options['slider_animation']) ) :
		$params['animation'] = esc_js($theme_options['slider_animation']);
	endif;
	
	// Passing Parameters to Javascript
	wp_localize_script( 'dynamicnewslite-jquery-frontpage_slider', 'dynamicnews_slider_params', $params );
}
endif;


?>