/**
 * Dynamic News Featured Content admin behavior: add a tag suggestion
 * when changing the tag.
 *
 *
 * Original Code: Twenty Fourteen http://wordpress.org/themes/twentyfourteen
 * Original Copyright: the WordPress team and contributors.
 * 
 * The following code is a derivative work of the code from the  Twenty Fourteen theme, 
 * which is licensed GPLv2. This code therefore is also licensed under the terms 
 * of the GNU Public License, version 2.
 */
/* global ajaxurl:true */

jQuery( document ).ready( function( $ ) {
	$( '#customize-control-featured-content-tag-name input' ).suggest( ajaxurl + '?action=ajax-tag-search&tax=post_tag', { delay: 500, minchars: 2 } );
});
