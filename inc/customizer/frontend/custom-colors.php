<?php
/***
 * Custom Color Options
 *
 * Get custom colors from theme options and embed CSS color settings 
 * in the <head> area of the theme. 
 *
 */


// Add Custom Colors
add_action('wp_head', 'dynamicnews_custom_colors');
function dynamicnews_custom_colors() { 
	
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	// Set Color CSS Variable
	$color_css = '';
	
	// Set Primary Header & Menu Color
	if ( isset($theme_options['menu_primary_color']) and $theme_options['menu_primary_color'] <> '#333333' ) : 
	
		$color_css .= '
			#logo a:hover .site-title {
				color: '. $theme_options['menu_primary_color'] .';
			}
			#navi-wrap, #social-icons-menu li a:hover {
				background-color: '. $theme_options['menu_primary_color'] .';
			}';
			
	endif;
	
	// Set Secondary Header & Menu Color
	if ( isset($theme_options['menu_secondary_color']) and $theme_options['menu_secondary_color'] <> '#e84747' ) : 
	
		$color_css .= '
			#logo .site-title {
				color: '. $theme_options['menu_secondary_color'] .';
			}
			#mainnav-menu a:hover, #mainnav-menu ul a:hover, #mainnav-icon:hover, #social-icons-menu li a {
				background-color:  '. $theme_options['menu_secondary_color'] .';
			}';
			
	endif;
	
	// Set Primary Post Area Color
	if ( isset($theme_options['post_primary_color']) and $theme_options['post_primary_color'] <> '#333333' ) : 
	
		$color_css .= '
			.page-title, .post-title, .post-title a:link, .post-title a:visited, .archive-title span, 
			.postmeta a:link, .postmeta a:visited, #comments .comments-title, #respond #reply-title {
				color: '. $theme_options['post_primary_color'] .';
			}
			input[type="submit"]:hover, .more-link:hover, .postinfo .meta-category a, #commentform #submit:hover {
				background-color: '. $theme_options['post_primary_color'] .';
			}
			.page-title, .post-title, #comments .comments-title, #respond #reply-title {
				border-bottom: 5px solid '. $theme_options['post_primary_color'] .';
			}';
			
	endif;
	
	// Set Secondary Post Area Color
	if ( isset($theme_options['post_secondary_color']) and $theme_options['post_secondary_color'] <> '#e84747' ) : 
	
		$color_css .= '
			a, a:link, a:visited, .comment a:link, .comment a:visited, 
			.post-title a:hover, .post-title a:active, .post-pagination a:link, .post-pagination a:visited {
				color: '. $theme_options['post_secondary_color'] .';
			} 
			.postinfo .meta-category a:hover, .postinfo .meta-category a:active,
			.bypostauthor .fn, .comment-author-admin .fn, input[type="submit"], .more-link, #commentform #submit {
				background-color:  '. $theme_options['post_secondary_color'] .';
			}';
			
	endif;
	
	// Set Widget Title Color
	if ( isset($theme_options['widget_title_color']) and $theme_options['widget_title_color'] <> '#333333' ) : 
	
		$color_css .= '
			#sidebar .widgettitle, #sidebar .widget-tabnav li a:hover, #frontpage-magazine-widgets .widget .widgettitle {
				background: '. $theme_options['widget_title_color'] .';
			}
			';
			
	endif;
	
	// Set Widget Link Color
	if ( isset($theme_options['widget_link_color']) and $theme_options['widget_link_color'] <> '#e84747' ) : 
	
		$color_css .= '
			#sidebar .widget a:link, #sidebar .widget a:visited {
				color: '. $theme_options['widget_link_color'].';
			}
			.widget-tabnav li a, .widget-tabnav li a:link, .widget-tabnav li a:visited {
				color: #fff !important;
				background: '. $theme_options['widget_link_color'].';
			}';
			
	endif;
	
	// Set Primary Slider Color
	if ( isset($theme_options['slider_primary_color']) and $theme_options['slider_primary_color'] <> '#333333' ) : 
	
		$color_css .= '
			#frontpage-slider .zeeslide .slide-entry, .frontpage-slider-controls .zeeflex-direction-nav a, .frontpage-slider-controls .zeeflex-control-paging li a {
				background-color: '. $theme_options['slider_primary_color'] .';
			}';
			
	endif;
	
	// Set Secondary Slider Color
	if ( isset($theme_options['slider_secondary_color']) and $theme_options['slider_secondary_color'] <> '#e84747' ) : 
	
		$color_css .= '
			#frontpage-slider-wrap:hover .frontpage-slider-controls a:hover, .frontpage-slider-controls .zeeflex-control-paging li a.zeeflex-active {
				background-color:  '. $theme_options['slider_secondary_color'] .';
			}
			#frontpage-slider .zeeslide .slide-entry {
				border-top: 10px solid '. $theme_options['slider_secondary_color'] .';
			}';
			
	endif;
	
	// Set Footer Color
	if ( isset($theme_options['footer_color']) and $theme_options['footer_color'] <> '#333333' ) : 
	
		$color_css .= '
			#footer-widgets-bg, #footer-wrap {
				background-color: '.  $theme_options['footer_color'] .';
			}';
			
	endif;
	
	
	// Print Color CSS
	if ( isset($color_css) and $color_css <> '' ) :
	
		echo '<style type="text/css">';
		echo $color_css;
		echo '</style>';
	
	endif;
	
}