<?php
/**
 * Theme Customizer Functions
 *
 */

/*========================== CUSTOMIZER CONTROLS FUNCTIONS ==========================*/

if ( class_exists( 'WP_Customize_Control' ) ) :

	// Title Control
	class Dynamic_News_Customize_Header_Control extends WP_Customize_Control {

		public function render_content() {
	?>

			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			</label>

			<?php
		}
	}

	// Description Control
	class Dynamic_News_Customize_Description_Control extends WP_Customize_Control {

		public function render_content() {
	?>

			<span class="description"><?php echo esc_html( $this->label ); ?></span>

			<?php
		}
	}

	// Upgrade Control
	class Dynamic_News_Customize_Upgrade_Control extends WP_Customize_Control {

		public function render_content() {
	?>

			<div class="upgrade-pro-version">

				<span class="customize-control-title"><?php esc_html_e( 'Pro Version Add-on', 'dynamic-news-lite' ); ?></span>

				<span class="textfield">
					<?php printf( esc_html__( 'Purchase the %s Pro Add-on and get additional features and advanced customization options.', 'dynamic-news-lite' ), 'Dynamic News' ); ?>
				</span>

				<p>
					<a href="<?php echo esc_url( __( 'https://themezee.com/addons/dynamicnews-pro/', 'dynamic-news-lite' ) ); ?>?utm_source=customizer&utm_medium=button&utm_campaign=dynamicnews&utm_content=pro-version" target="_blank" class="button button-secondary">
						<?php printf( esc_html__( 'Learn more about %s Pro', 'dynamic-news-lite' ), 'Dynamic News' ); ?>
					</a>
				</p>

			</div>

			<div class="upgrade-plugins">

				<span class="customize-control-title"><?php esc_html_e( 'Recommended Plugins', 'dynamic-news-lite' ); ?></span>

				<span class="textfield">
					<?php esc_html_e( 'Extend the functionality of your WordPress website with our free and easy to use plugins.', 'dynamic-news-lite' ); ?>
				</span>

				<p>
					<a href="<?php echo admin_url( 'plugin-install.php?tab=search&type=author&s=themezee' ); ?>" class="button button-secondary">
						<?php esc_html_e( 'Install Plugins', 'dynamic-news-lite' ); ?>
					</a>
				</p>

			</div>

			<?php
		}
	}

endif;


// Add a callback function to retrieve wether posts length setting is set to excerpt or not
function dynamicnews_control_posts_length_callback( $control ) {

	// Check if excerpt mode is selected
	if ( $control->manager->get_setting( 'dynamicnews_theme_options[posts_length]' )->value() == 'excerpt' ) :
		return true;
	else :
		return false;
	endif;

}

// Add a callback function to retrieve wether slider is activated or not
function dynamicnews_slider_activated_callback( $control ) {

	// Check if Slider is turned on
	if ( $control->manager->get_setting( 'dynamicnews_theme_options[slider_activated_front_page]' )->value() == 1 ) :
		return true;
	elseif ( $control->manager->get_setting( 'dynamicnews_theme_options[slider_activated_blog]' )->value() == 1 ) :
		return true;
	else :
		return false;
	endif;

}
