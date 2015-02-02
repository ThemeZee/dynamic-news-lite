<?php
/**
 * Returns theme options
 *
 * Uses sane defaults in case the user has not configured any theme options yet.
 */


// Return theme options
function dynamicnews_theme_options() {
    
	// Merge Theme Options Array from Database with Default Options Array
	$theme_options = wp_parse_args( 
		
		// Get saved theme options from WP database
		get_option( 'dynamicnews_theme_options', array() ), 
		
		// Merge with Default Options if setting was not saved yet
		dynamicnews_default_options() 
		
	);

	// Return theme options
	return $theme_options;
	
}


// Build default options array
function dynamicnews_default_options() {

	$default_options = array(
		'layout' 							=> 'boxed',
		'sidebar' 							=> 'right-sidebar',
		'deactivate_google_fonts'			=> false,
		'header_logo' 						=> '',
		'header_tagline' 					=> false,
		'header_search' 					=> false,
		'header_icons' 						=> false,
		'header_text' 						=> '',
		'posts_length' 						=> 'index',
		'post_thumbnails_index'				=> true,
		'post_thumbnails_single' 			=> true,
		'excerpt_text' 						=> '',
		'credit_link' 						=> true,
		'slider_activated_front_page' 		=> false,
		'slider_activated_blog' 			=> false,
		'slider_animation' 					=> 'horizontal'
	);
	
	return $default_options;
}


?>