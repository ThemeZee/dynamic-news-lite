<?php
/**
 * Custom functions that are not template related
 *
 * @package Dynamic News Lite
 */


// Add Default Menu Fallback Function
function dynamicnews_default_menu() {
	echo '<ul id="mainnav-menu" class="main-navigation-menu menu">' . wp_list_pages( 'title_li=&echo=0' ) . '</ul>';
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
	if ( 'wide' === $theme_options['layout'] ) :
		$classes[] = 'wide-layout';
	elseif ( 'flat' === $theme_options['layout'] ) :
		$classes[] = 'flat-layout';
	endif;

	// Switch Sidebar Layout to left
	if ( 'left-sidebar' === $theme_options['sidebar'] ) :
		$classes[] = 'sidebar-left';
	endif;

	// Add Sliding Sidebar on mobile devices
	if ( true == $theme_options['sliding_sidebar'] ) :
		$classes[] = 'sliding-sidebar';
	endif;

	// Add Mobile Header area class
	if ( '' <> $theme_options['mobile_header'] ) :
		$classes[] = 'mobile-header-' . $theme_options['mobile_header'];
	endif;

	return $classes;
}
add_filter( 'body_class', 'dynamicnews_body_classes' );


/**
 * Hide Elements with CSS.
 *
 * @return void
 */
function dynamicnews_hide_elements() {

	// Get theme options from database.
	$theme_options = dynamicnews_theme_options();

	$elements = array();

	// Hide Site Title?
	if ( false == $theme_options['site_title'] ) {
		$elements[] = '.site-title';
	}

	// Hide Site Description?
	if ( false == $theme_options['header_tagline'] ) {
		$elements[] = '.site-description';
	}

	// Return early if no elements are hidden.
	if ( empty( $elements ) ) {
		return;
	}

	// Create CSS.
	$classes = implode( ', ', $elements );
	$custom_css = $classes . ' {
	position: absolute;
	clip: rect(1px, 1px, 1px, 1px);
}';

	// Add Custom CSS.
	wp_add_inline_style( 'dynamicnewslite-stylesheet', $custom_css );
}
add_filter( 'wp_enqueue_scripts', 'dynamicnews_hide_elements', 11 );


// Change Excerpt Length
add_filter( 'excerpt_length', 'dynamicnews_excerpt_length' );
function dynamicnews_excerpt_length( $length ) {

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Return Excerpt Length
	if ( $theme_options['excerpt_length'] >= 0 ) :
		return absint( $theme_options['excerpt_length'] );
	else :
		return 60; // number of words
	endif;

}


// Slideshow Excerpt Length
function dynamicnews_slideshow_excerpt_length( $length ) {
	return 30;
}

// Frontpage Category Excerpt Length
function dynamicnews_frontpage_category_excerpt_length( $length ) {
	return 25;
}


// Change Excerpt More
add_filter( 'excerpt_more', 'dynamicnews_excerpt_more' );
function dynamicnews_excerpt_more( $more ) {

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Return Excerpt Text
	if ( true == $theme_options['excerpt_text'] ) :
		return ' [...]';
	else :
		return '';
	endif;
}
