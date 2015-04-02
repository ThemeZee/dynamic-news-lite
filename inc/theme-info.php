<?php
/***
 * Theme Info
 *
 * Adds a simple Theme Info page to the Appearance section of the WordPress Dashboard. 
 *
 */


// Add Theme Info page to admin menu
add_action('admin_menu', 'dynamicnews_add_theme_info_page');
function dynamicnews_add_theme_info_page() {
	
	add_theme_page( 
		__('Welcome to Dynamic News Lite', 'dynamicnewslite'), 
		__('Theme Info', 'dynamicnewslite'), 
		'edit_theme_options', 
		'dynamicnewslite', 
		'dynamicnews_display_theme_info_page'
	);
	
}


// Display Theme Info page
function dynamicnews_display_theme_info_page() { 
	
	// Get Theme Details from style.css
	$theme_data = wp_get_theme(); 
	
?>
			
	<div class="wrap theme-info-wrap">

		<h1><?php printf( __( 'Welcome to %1s %2s', 'dynamicnewslite' ), $theme_data->Name, $theme_data->Version ); ?></h1>

		<div class="theme-description"><?php echo $theme_data->Description; ?></div>
		
		<hr>
		<div class="important-links clearfix">
			<p><strong><?php _e('Important Links:', 'dynamicnewslite'); ?></strong>
				<a href="http://themezee.com/themes/dynamicnews/" target="_blank"><?php _e('Theme Info Page', 'dynamicnewslite'); ?></a>
				<a href="<?php echo get_template_directory_uri(); ?>/changelog.txt" target="_blank"><?php _e('Changelog', 'dynamicnewslite'); ?></a>
				<a href="http://preview.themezee.com/dynamicnews/" target="_blank"><?php _e('Theme Demo', 'dynamicnewslite'); ?></a>
				<a href="http://themezee.com/docs/dynamicnews-documentation/" target="_blank"><?php _e('Theme Documentation', 'dynamicnewslite'); ?></a>
				<a href="http://wordpress.org/support/view/theme-reviews/dynamic-news-lite?filter=5" target="_blank"><?php _e('Rate this theme', 'dynamicnewslite'); ?></a>
			</p>
		</div>
		<hr>
				
		<div id="getting-started">

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">
				
					<h3><?php printf( __( 'Getting Started with %s', 'dynamicnewslite' ), $theme_data->Name ); ?></h3>
						
					<div class="section">
						<h4><?php _e( 'Theme Documentation', 'dynamicnewslite' ); ?></h4>
						
						<p class="about"><?php _e( 'Need any help to setup and configure this theme? We got you covered with an extensive theme documentation on our website.', 'dynamicnewslite' ); ?></p>
						<p>
							<a href="http://themezee.com/docs/dynamicnews-documentation/" target="_blank" class="button button-secondary"><?php _e('Visit Dynamic News Documentation', 'dynamicnewslite'); ?></a>
						</p>
					</div>
					
					<div class="section">
						<h4><?php _e( 'Theme Options', 'dynamicnewslite' ); ?></h4>
						
						<p class="about"><?php _e( 'Dynamic News supports the awesome Theme Customizer for all theme settings. Click "Customize Theme" to open the Customizer now.', 'dynamicnewslite' ); ?></p>
						<p>
							<a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-primary"><?php _e('Customize Theme', 'dynamicnewslite'); ?></a>
						</p>
					</div>
					
					<div class="section">
						<h4><?php _e( 'PRO Version', 'dynamicnewslite' ); ?></h4>
						
						<p class="about"><?php _e( 'Need more features? Check out the PRO version which comes with additional features and advanced customization options.', 'dynamicnewslite' ); ?></p>
						<p>
							<a href="http://themezee.com/themes/dynamicnews/#PROVersion-1" target="_blank" class="button button-secondary"><?php _e('Learn more about the PRO Version of Dynamic News', 'dynamicnewslite'); ?></a>
						</p>
					</div>

				</div>
				
				<div class="column column-half clearfix">
					
					<img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" />
					
				</div>
				
			</div>
			
		</div>
		
		<hr>
		
		<div id="theme-author">
			
			<p><?php printf( __( 'Dynamic News is proudly brought to you by %1s. If you like this theme, %2s :) ', 'dynamicnewslite' ), 
				'<a target="_blank" href="http://themezee.com" title="ThemeZee">ThemeZee</a>',
				'<a target="_blank" href="http://wordpress.org/support/view/theme-reviews/dynamic-news-lite?filter=5" title="Dynamic News Lite Review">' . __( 'rate it', 'dynamicnewslite' ) . '</a>'); ?>
			</p>
		
		</div>
	
	</div>

<?php
}


// Add CSS for Theme Info Panel
add_action('admin_enqueue_scripts', 'dynamicnews_theme_info_page_css');
function dynamicnews_theme_info_page_css($hook) { 

	// Load styles and scripts only on theme info page
	if ( 'appearance_page_dynamicnewslite' != $hook ) {
		return;
	}
	
	// Embed theme info css style
	wp_enqueue_style('dynamicnewslite-theme-info-css', get_template_directory_uri() .'/css/theme-info.css');

}


?>