<?php
/***
 * Custom Slider Parameters
 *
 * Passing Variables from custom Theme Options to the javascript files
 * of featured content slider.
 *
 */

// Passing Variables to Featured Content Slider ( js/slider.js)
add_action( 'wp_enqueue_scripts', 'dynamicnews_custom_slider_parameter' );

if ( ! function_exists( 'dynamicnews_custom_slider_parameter' ) ) :

	function dynamicnews_custom_slider_parameter() {

		// Get Theme Options from Database
		$theme_options = dynamicnews_theme_options();

		// Set Parameters array
		$params = array();

		// Define Slider Animation
		$params['animation'] = $theme_options['slider_animation'];

		// Define Slider Speed
		$params['speed'] = $theme_options['slider_speed'];

		// Passing Parameters to Javascript
		wp_localize_script( 'dynamicnewslite-jquery-frontpage_slider', 'dynamicnews_slider_params', $params );
	}

endif;
