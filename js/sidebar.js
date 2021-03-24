/**
 * jQuery Sidebar JS
 *
 * Adds a toggle icon with slide animation for the sidebar on mobile devices
 *
 * Copyright 2015 ThemeZee
 * Free to use under the GPLv2 and later license.
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Author: Thomas Weichselbaumer (themezee.com)
 *
 * @package Dynamic News Lite
 */

(function($) {

	/**--------------------------------------------------------------
	# Setup Sidebar Menu
	--------------------------------------------------------------*/
	$( document ).ready( function() {

		/* Show sidebar and fade content area */
		function showSidebar() {

			sidebar.show();
			sidebar.animate( { 'max-width' : '400px' }, 300 );

			overlay.show();

		}

		/* Hide sidebar and show full content area */
		function hideSidebar() {

			sidebar.animate({ 'max-width': '0' },  300, function(){
				sidebar.hide();
			});

			overlay.hide();
		}

		/* Reset sidebar on desktop screen sizes */
		function resetSidebar() {

			sidebar.show();
			sidebar.css( { 'max-width' : '100%' } );

			overlay.hide();
		}

		/* Only do something if sidebar exists */
		if ( $( '#sidebar' ).length > 0 ) {

			/* Add sidebar toggle */
			$( '#navi-wrap' ).before( '<button id=\"sidebar-toggle\" class=\"sidebar-navigation-toggle\">' + dynamicnews_sidebar_title.text + '</button>' );

			/* Add sidebar closing toggle */
			$( '#sidebar' ).prepend( '<button id=\"sidebar-close\" class=\"sidebar-closing-toggle\">' + dynamicnews_sidebar_title.text + '</button>' );

			/* Add Overlay */
			$( 'body' ).append( '<div id=\"sidebar-overlay\"></div>' );

			/* Setup Selectors */
			var button = $( '#sidebar-toggle' ),
				close = $( '#sidebar-close' ),
				sidebar = $( '#sidebar' ),
				overlay = $( '#sidebar-overlay' );

			/* Add sidebar toggle effect */
			button.on('click', function(){
				if ( sidebar.is( ':visible' ) ) {
					hideSidebar();
				} else {
					showSidebar();
				}
			});

			/* Sidebar Close */
			close.on('click', function(){
				hideSidebar();
			});

		}

		/* Reset sidebar menu on desktop screens */
		if (typeof matchMedia == 'function') {
			var mq = window.matchMedia( '(max-width: 60em)' );
			mq.addListener( widthChange );
			widthChange( mq );
		}
		function widthChange(mq) {

			/* Only do something if sidebar exists */
			if ( $( '#sidebar' ).length <= 0 ) {
				return;
			}

			if (mq.matches) {

				sidebar.hide();

				/* Hide Sidebar when Content Area is clicked */
				overlay.on('click', function(e){
					if ( sidebar.is( ':visible' ) ) {
						e.preventDefault();
						hideSidebar();
					}
				});

			} else {

				/* Reset Sidebar Menu */
				resetSidebar();
				overlay.unbind( 'click' );

			}

		}

	} );

}(jQuery));
