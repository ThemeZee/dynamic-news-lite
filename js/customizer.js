/*
 * Customizer.js to reload changes on Theme Customizer Preview asynchronously.
 *
 */

( function( $ ) {

	/* Default WordPress Customizer settings */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '#logo .site-title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '#logo .site-description' ).text( to );
		} );
	} );
	
	/* Theme Colors */
	wp.customize( 'dynamicnews_theme_options[widget_title_color]', function( value ) {
		value.bind( function( newval ) {
			$('#sidebar .widgettitle, #sidebar .widget-tabnav li a:hover, #frontpage-magazine-widgets .widget .widgettitle')
				.css('background', newval );
			
		} );
	} );
	
	wp.customize( 'dynamicnews_theme_options[widget_link_color]', function( value ) {
		value.bind( function( newval ) {
			$('#sidebar .widget a:link, #sidebar .widget a:visited')
				.css('color', newval );
			$('.widget-tabnav li a, .widget-tabnav li a:link, .widget-tabnav li a:visited')
				.css('background', newval ).css('color', '#ffffff !important' );
		} );
	} );
	
	wp.customize( 'dynamicnews_theme_options[footer_color]', function( value ) {
		value.bind( function( newval ) {
			$('#footer-wrap, #footer-widgets-bg')
				.css('background', newval );
		} );
	} );
	

} )( jQuery );