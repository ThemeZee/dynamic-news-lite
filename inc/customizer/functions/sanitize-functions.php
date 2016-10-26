<?php
/**
 * Theme Customizer Functions
 *
 */

/*========================== CUSTOMIZER SANITIZE FUNCTIONS ==========================*/

// Sanitize checkboxes
function dynamicnews_sanitize_checkbox( $checked ) {

	// Boolean check.
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}


// Sanitize the layout width value.
function dynamicnews_sanitize_layout( $value ) {

	if ( ! in_array( $value, array( 'boxed', 'wide', 'flat' ), true ) ) :
		$value = 'boxed';
	endif;

	return $value;
}


// Sanitize the layout sidebar value.
function dynamicnews_sanitize_sidebar( $value ) {

	if ( ! in_array( $value, array( 'left-sidebar', 'right-sidebar', 'fullwidth' ), true ) ) :
		$value = 'right-sidebar';
	endif;

	return $value;
}


// Sanitize the mobile header value.
function dynamicnews_sanitize_mobile_header( $value ) {

	if ( ! in_array( $value, array( 'none', 'social', 'search', 'text', 'widgets' ), true ) ) :
		$value = 'boxed';
	endif;

	return $value;
}


// Sanitize the post length value.
function dynamicnews_sanitize_post_length( $value ) {

	if ( ! in_array( $value, array( 'index', 'excerpt' ), true ) ) :
		$value = 'index';
	endif;

	return $value;
}


// Sanitize the slider animation value.
function dynamicnews_sanitize_slider_animation( $value ) {

	if ( ! in_array( $value, array( 'slide', 'fade' ), true ) ) :
		$value = 'slide';
	endif;

	return $value;
}
