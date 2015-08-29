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
	
	// Get Theme Details from style.css
	$theme = wp_get_theme(); 
	
	add_theme_page( 
		sprintf( __( 'Welcome to %1$s %2$s', 'dynamic-news-lite' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ), 
		__('Theme Info', 'dynamic-news-lite'), 
		'edit_theme_options', 
		'dynamicnews', 
		'dynamicnews_display_theme_info_page'
	);
	
}


// Display Theme Info page
function dynamicnews_display_theme_info_page() { 
	
	// Get Theme Details from style.css
	$theme = wp_get_theme(); 
	
?>
			
	<div class="wrap theme-info-wrap">

		<h1><?php printf( __( 'Welcome to %1$s %2$s', 'dynamic-news-lite' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ); ?></h1>

		<div class="theme-description"><?php echo $theme->get( 'Description' ); ?></div>
		
		<hr>
		<div class="important-links clearfix">
			<p><strong><?php _e('Important Links:', 'dynamic-news-lite'); ?></strong>
				<a href="http://themezee.com/themes/dynamicnews/" target="_blank"><?php _e('Theme Page', 'dynamic-news-lite'); ?></a>
				<a href="<?php echo get_template_directory_uri(); ?>/changelog.txt" target="_blank"><?php _e('Changelog', 'dynamic-news-lite'); ?></a>
				<a href="http://preview.themezee.com/dynamicnews/" target="_blank"><?php _e('Theme Demo', 'dynamic-news-lite'); ?></a>
				<a href="http://themezee.com/docs/dynamicnews-documentation/" target="_blank"><?php _e('Theme Documentation', 'dynamic-news-lite'); ?></a>
				<a href="http://wordpress.org/support/view/theme-reviews/dynamic-news-lite?filter=5" target="_blank"><?php _e('Rate this theme', 'dynamic-news-lite'); ?></a>
			</p>
		</div>
		<hr>
				
		<div id="getting-started">

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">
				
					<h3><?php printf( __( 'Getting Started with %s', 'dynamic-news-lite' ), $theme->get( 'Name' ) ); ?></h3>
						
					<div class="section">
						<h4><?php _e( 'Theme Documentation', 'dynamic-news-lite' ); ?></h4>
						
						<p class="about">
							<?php _e( 'You need help to setup and configure this theme? We got you covered with an extensive theme documentation on our website.', 'dynamic-news-lite' ); ?>
						</p>
						<p>
							<a href="http://themezee.com/docs/dynamicnews-documentation/" target="_blank" class="button button-secondary">
								<?php printf( __( 'View %s Documentation', 'dynamic-news-lite' ), 'Dynamic News' ); ?>
							</a>
						</p>
					</div>
					
					<div class="section">
						<h4><?php _e( 'Theme Options', 'dynamic-news-lite' ); ?></h4>
						
						<p class="about">
							<?php printf( __( '%s makes use of the Customizer for all theme settings. Click on "Customize Theme" to open the Customizer now.', 'dynamic-news-lite' ), $theme->get( 'Name' ) ); ?>
						</p>
						<p>
							<a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-primary"><?php _e('Customize Theme', 'dynamic-news-lite'); ?></a>
						</p>
					</div>
					
					<div class="section">
						<h4><?php _e( 'Pro Version', 'dynamic-news-lite' ); ?></h4>
						
						<p class="about">
							<?php _e( 'You need more features? Purchase the Pro Version to get additional features and advanced customization options.', 'dynamic-news-lite' ); ?>
						</p>
						<p>
							<a href="http://themezee.com/themes/dynamicnews/#PROVersion-1" target="_blank" class="button button-secondary">
								<?php printf( __( 'Learn more about %s Pro', 'dynamic-news-lite' ), 'Dynamic News'); ?>
							</a>
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
			
			<p><?php printf( __( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'dynamic-news-lite' ), 
				$theme->get( 'Name' ),
				'<a target="_blank" href="http://themezee.com" title="ThemeZee">ThemeZee</a>',
				'<a target="_blank" href="http://wordpress.org/support/view/theme-reviews/dynamic-news-lite?filter=5" title="Dynamic News Lite Review">' . __( 'rate it', 'dynamic-news-lite' ) . '</a>'); ?>
			</p>
		
		</div>
	
	</div>

<?php
}


// Add CSS for Theme Info Panel
add_action('admin_enqueue_scripts', 'dynamicnews_theme_info_page_css');
function dynamicnews_theme_info_page_css($hook) { 

	// Load styles and scripts only on theme info page
	if ( 'appearance_page_dynamicnews' != $hook ) {
		return;
	}
	
	// Embed theme info css style
	wp_enqueue_style('dynamicnewslite-theme-info-css', get_template_directory_uri() .'/css/theme-info.css');

}


?>