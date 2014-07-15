<?php

// Include Fonts from Google Web Fonts API
function dynamicnews_load_web_fonts() { 

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Default Fonts which haven't to be load from Google
	$default_fonts = array('Arial', 'Verdana', 'Tahoma', 'Times New Roman');
	
	// Embed Text Font
	if( isset($theme_options['text_font']) and !in_array($theme_options['text_font'], $default_fonts)) :
		
		wp_register_style('dynamicnews-text-font', '//fonts.googleapis.com/css?family=' . $theme_options['text_font']);
		wp_enqueue_style('dynamicnews-text-font');
		
		// add embedded font to array to prevent second font embed
		$default_fonts[] = $theme_options['text_font']; 
	endif;
	
	// Embed Title Font
	if( isset($theme_options['title_font']) and !in_array($theme_options['title_font'], $default_fonts)) :
		
		wp_register_style('dynamicnews-title-font', '//fonts.googleapis.com/css?family=' . $theme_options['title_font']);
		wp_enqueue_style('dynamicnews-title-font');
		
		// add embedded font to array to prevent second font embed
		$default_fonts[] = $theme_options['title_font']; 
	endif;
	
	// Embed Navigation Font
	if( isset($theme_options['navi_font']) and !in_array($theme_options['navi_font'], $default_fonts)) :
		
		wp_register_style('dynamicnews-navi-font', '//fonts.googleapis.com/css?family=' . $theme_options['navi_font']);
		wp_enqueue_style('dynamicnews-navi-font');
		
		// add embedded font to array to prevent second font embed
		$default_fonts[] = $theme_options['navi_font']; 
	endif;

	// Embed Widget Title Font
	if( isset($theme_options['widget_title_font']) and !in_array($theme_options['widget_title_font'], $default_fonts)) :
		
		wp_register_style('dynamicnews-widget-title-font', '//fonts.googleapis.com/css?family=' . $theme_options['widget_title_font']);
		wp_enqueue_style('dynamicnews-widget-title-font');
		
		// add embedded font to array to prevent second font embed
		$default_fonts[] = $theme_options['widget_title_font']; 
	endif;

}
add_action('wp_enqueue_scripts', 'dynamicnews_load_web_fonts');


add_action('wp_head', 'dynamicnews_css_fonts');
function dynamicnews_css_fonts() {
	
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Set Font CSS Variable
	$font_css = '';
	
	// Set Default Text Font
	if ( isset($theme_options['text_font']) and $theme_options['text_font'] <> 'Droid Sans' ) : 
	
		$font_css .= '
			body, input, textarea {
				font-family: "'.esc_attr($theme_options['text_font']).'";
			}';
		
	endif;
	
	// Set Title Font
	if ( isset($theme_options['title_font']) and $theme_options['title_font'] <> 'Francois One' ) : 
	
		$font_css .= '
			#logo .site-title, .page-title, .post-title, #frontpage-slider .zeeslide .slide-entry .slide-title,
			#comments .comments-title, #respond #reply-title {
				font-family: "'.esc_attr($theme_options['title_font']).'";
			}';
		
	endif;
	
	// Set Navigation Font
	if ( isset($theme_options['navi_font']) and $theme_options['navi_font'] <> 'Francois One' ) : 
	
		$font_css .= '
			#mainnav-icon, #mainnav-menu a {
				font-family: "'.esc_attr($theme_options['navi_font']).'";
			}';
		
	endif;
	
	// Set Widget Title Font
	if ( isset($theme_options['widget_title_font']) and $theme_options['widget_title_font'] <> 'Droid Sans' ) : 
	
		$font_css .= '
			.widgettitle, #frontpage-magazine-widgets .widget .widgettitle {
				font-family: "'.esc_attr($theme_options['widget_title_font']).'";
			}';
		
	endif;
	
	// Print Font CSS
	if ( isset($font_css) and $font_css <> '' ) :
	
		echo '<style type="text/css">';
		echo $font_css;
		echo '</style>';
	
	endif;
}


