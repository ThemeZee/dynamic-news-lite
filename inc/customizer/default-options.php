<?php
/**
 * Returns theme options
 *
 * Uses sane defaults in case the user has not configured any theme options yet.
 */


// Return theme options
function dynamicnews_theme_options() {
    
	// Get theme options from DB
	$theme_options = get_option( 'dynamicnews_theme_options' );
    
	// Check if user has already configured theme options
	if ( false === $theme_options ) :
		
		// Set Default Options
		$theme_options = dynamicnews_default_options();
		
    endif;
	
	// Return theme options
	return $theme_options;
}


// Build default options array
function dynamicnews_default_options() {

	$default_options = array(
		'layout' 							=> 'boxed',
		'sidebar' 							=> 'right-sidebar',
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