<?php 
add_action('wp_head', 'dynamicnews_css_layout');
function dynamicnews_css_layout() {
	
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
		
	// Change Layout to wide if activated
	if ( isset($theme_options['layout']) and $theme_options['layout'] == 'wide' ) :
	
		echo '<style type="text/css">
			@media only screen and (min-width: 60em) {
				#wrapper {
					margin: 0;
					width: 100%;
					max-width: 100%;
					background: none;
				}
				#header {
					padding: 3em 0.5em;
				}
				.container {
					max-width: 1340px;
					width: 92%;
					margin: 0 auto;
					-webkit-box-sizing: border-box;
					-moz-box-sizing: border-box;
					box-sizing: border-box;
				}
				#wrap {
					padding: 1.5em 0;
				}
			}
			@media only screen and (max-width: 70em) {
				.container {
					width: 94%;
				}
			}
			@media only screen and (max-width: 65em) {
				.container {
					width: 96%;
				}
				#wrapper {
					background: #fff;
				}
			}
			@media only screen and (max-width: 60em) {
				.container {
					width: 100%;
					margin: 0;
					-webkit-box-sizing: border-box;
					-moz-box-sizing: border-box;
					box-sizing: border-box;
				}
				#wrap {
					padding: 1.5em 1.5em 0;
				}
			}
		</style>';
	
	endif;
	
	
	// Switch Sidebar to left
	if ( isset($theme_options['sidebar']) and $theme_options['sidebar'] == 'left-sidebar' ) :
	
		echo '<style type="text/css">
			@media only screen and (min-width: 60em) {
				#content {
					float: right;
					padding-right: 0;
					padding-left: 1.5em;
				}
				#sidebar {
					float: left;
				}
			}
		</style>';
	
	endif;
	
}