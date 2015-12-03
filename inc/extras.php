<?php
/**
 * Custom functions that are not template related
 *
 * @package Dynamic News Lite
 */


// Add Default Menu Fallback Function
function dynamicnews_default_menu() {
	echo '<ul id="mainnav-menu" class="menu">'. wp_list_pages('title_li=&echo=0') .'</ul>';
}


// Get Featured Posts
function dynamicnews_get_featured_content() {
	return apply_filters( 'dynamicnews_get_featured_content', false );
}

/**
 * Adds custom theme design and sidebar layout classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function dynamicnews_body_classes( $classes ) {
	
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Add Theme Design class
	if ( isset($theme_options['layout']) and $theme_options['layout'] == 'wide' ) :
		$classes[] = 'wide-layout';
	elseif ( isset($theme_options['layout']) and $theme_options['layout'] == 'flat' ) :
		$classes[] = 'flat-layout';
	endif;

	// Switch Sidebar Layout to left
	if ( isset($theme_options['sidebar']) and $theme_options['sidebar'] == 'left-sidebar' ) :
		$classes[] = 'sidebar-left';
	endif;
	
	// Add Sliding Sidebar on mobile devices
	if ( true == $theme_options['sliding_sidebar'] ) :
		$classes[] = 'sliding-sidebar';
	endif;
	
	// Add Mobile Header area class
	if ( isset($theme_options['mobile_header']) and $theme_options['mobile_header'] <> '' ) :
		$classes[] = 'mobile-header-' . $theme_options['mobile_header'];
	endif;

	return $classes;
}
add_filter( 'body_class', 'dynamicnews_body_classes' );


// Change Excerpt Length
add_filter('excerpt_length', 'dynamicnews_excerpt_length');
function dynamicnews_excerpt_length($length) {

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Return Excerpt Length
	if ( isset($theme_options['excerpt_length']) and $theme_options['excerpt_length'] >= 0 ) :
		return absint( $theme_options['excerpt_length'] );
	else :
		return 60; // number of words
	endif;

}


// Slideshow Excerpt Length
function dynamicnews_slideshow_excerpt_length($length) {
    return 30;
}

// Frontpage Category Excerpt Length
function dynamicnews_frontpage_category_excerpt_length($length) {
    return 25;
}


// Change Excerpt More
add_filter('excerpt_more', 'dynamicnews_excerpt_more');
function dynamicnews_excerpt_more($more) {
    
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Return Excerpt Text
	if ( isset($theme_options['excerpt_text']) and $theme_options['excerpt_text'] == true ) :
		return ' [...]';
	else :
		return '';
	endif;
}