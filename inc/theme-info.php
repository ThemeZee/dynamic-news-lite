<?php
/**
 * Theme Info
 *
 * Adds a simple Theme Info page to the Appearance section of the WordPress Dashboard.
 *
 * @package Dynamic News
 */

/**
 * Add Theme Info page to admin menu
 */
function dynamicnews_theme_info_menu_link() {

	// Get theme details.
	$theme = wp_get_theme();

	add_theme_page(
		sprintf( esc_html__( 'Welcome to %1$s %2$s', 'dynamic-news-lite' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ),
		esc_html__( 'Theme Info', 'dynamic-news-lite' ),
		'edit_theme_options',
		'dynamicnews',
		'dynamicnews_theme_info_page'
	);

}
add_action( 'admin_menu', 'dynamicnews_theme_info_menu_link' );

/**
 * Display Theme Info page
 */
function dynamicnews_theme_info_page() {

	// Get theme details.
	$theme = wp_get_theme();
	?>

	<div class="wrap theme-info-wrap">

		<h1><?php printf( esc_html__( 'Welcome to %1$s %2$s', 'dynamic-news-lite' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ); ?></h1>

		<div class="theme-description"><?php echo $theme->get( 'Description' ); ?></div>

		<hr>
		<div class="important-links clearfix">
			<p><strong><?php esc_html_e( 'Theme Links', 'dynamic-news-lite' ); ?>:</strong>
				<a href="<?php echo esc_url( __( 'https://themezee.com/themes/dynamicnews/', 'dynamic-news-lite' ) . '?utm_source=theme-info&utm_medium=textlink&utm_campaign=dynamicnews&utm_content=theme-page' ); ?>" target="_blank"><?php esc_html_e( 'Theme Page', 'dynamic-news-lite' ); ?></a>
				<a href="http://preview.themezee.com/?demo=dynamicnews&utm_source=theme-info&utm_campaign=dynamicnews" target="_blank"><?php esc_html_e( 'Theme Demo', 'dynamic-news-lite' ); ?></a>
				<a href="<?php echo esc_url( __( 'https://themezee.com/docs/dynamicnews-documentation/', 'dynamic-news-lite' ) . '?utm_source=theme-info&utm_medium=textlink&utm_campaign=dynamicnews&utm_content=documentation' ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'dynamic-news-lite' ); ?></a>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/support/theme/dynamic-news-lite/reviews/?filter=5', 'dynamic-news-lite' ) ); ?>" target="_blank"><?php esc_html_e( 'Rate this theme', 'dynamic-news-lite' ); ?></a>
			</p>
		</div>
		<hr>

		<div id="getting-started">

			<h3><?php printf( esc_html__( 'Getting Started with %s', 'dynamic-news-lite' ), $theme->get( 'Name' ) ); ?></h3>

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Theme Documentation', 'dynamic-news-lite' ); ?></h4>

						<p class="about">
							<?php esc_html_e( 'You need help to setup and configure this theme? We got you covered with an extensive theme documentation on our website.', 'dynamic-news-lite' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( __( 'https://themezee.com/docs/dynamicnews-documentation/', 'dynamic-news-lite' ) . '?utm_source=theme-info&utm_medium=button&utm_campaign=dynamicnews&utm_content=documentation' ); ?>" target="_blank" class="button button-secondary">
								<?php printf( esc_html__( 'View %s Documentation', 'dynamic-news-lite' ), 'Dynamic News' ); ?>
							</a>
						</p>
					</div>

					<div class="section">
						<h4><?php esc_html_e( 'Theme Options', 'dynamic-news-lite' ); ?></h4>

						<p class="about">
							<?php printf( esc_html__( '%s makes use of the Customizer for all theme settings. Click on "Customize Theme" to open the Customizer now.', 'dynamic-news-lite' ), $theme->get( 'Name' ) ); ?>
						</p>
						<p>
							<a href="<?php echo wp_customize_url(); ?>" class="button button-primary"><?php esc_html_e( 'Customize Theme', 'dynamic-news-lite' ); ?></a>
						</p>
					</div>

				</div>

				<div class="column column-half clearfix">

					<img src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>" />

				</div>

			</div>

		</div>

		<hr>

		<div id="more-features">

			<h3><?php esc_html_e( 'Get more features', 'dynamic-news-lite' ); ?></h3>

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Pro Version Add-on', 'dynamic-news-lite' ); ?></h4>

						<p class="about">
							<?php printf( esc_html__( 'Purchase the %s Pro Add-on and get additional features and advanced customization options.', 'dynamic-news-lite' ), 'Dynamic News' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( __( 'https://themezee.com/addons/dynamicnews-pro/', 'dynamic-news-lite' ) . '?utm_source=theme-info&utm_medium=button&utm_campaign=dynamicnews&utm_content=pro-version' ); ?>" target="_blank" class="button button-secondary">
								<?php printf( esc_html__( 'Learn more about %s Pro', 'dynamic-news-lite' ), 'Dynamic News' ); ?>
							</a>
						</p>
					</div>

				</div>

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Recommended Plugins', 'dynamic-news-lite' ); ?></h4>

						<p class="about">
							<?php esc_html_e( 'Extend the functionality of your WordPress website with our free and easy to use plugins.', 'dynamic-news-lite' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( admin_url( 'plugin-install.php?tab=search&type=author&s=themezee' ) ); ?>" class="button button-secondary">
								<?php esc_html_e( 'Install Plugins', 'dynamic-news-lite' ); ?>
							</a>
						</p>
					</div>

				</div>

			</div>

		</div>

		<hr>

		<div id="theme-author">

			<p><?php printf( esc_html__( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'dynamic-news-lite' ),
				$theme->get( 'Name' ),
				'<a target="_blank" href="' . __( 'https://themezee.com/', 'dynamic-news-lite' ) . '?utm_source=theme-info&utm_medium=footer&utm_campaign=dynamicnews" title="ThemeZee">ThemeZee</a>',
			'<a target="_blank" href="' . __( 'https://wordpress.org/support/theme/dynamic-news-lite/reviews/?filter=5', 'dynamic-news-lite' ) . '" title="' . esc_attr__( 'Review Dynamic News', 'dynamic-news-lite' ) . '">' . esc_html__( 'rate it', 'dynamic-news-lite' ) . '</a>'); ?>
			</p>

		</div>

	</div>

	<?php
}

/**
 * Enqueues CSS for Theme Info page
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function dynamicnews_theme_info_page_css( $hook ) {

	// Load styles and scripts only on theme info page.
	if ( 'appearance_page_dynamicnews' != $hook ) {
		return;
	}

	// Embed theme info css style.
	wp_enqueue_style( 'dynamicnews-theme-info-css', get_template_directory_uri() . '/css/theme-info.css' );

}
add_action( 'admin_enqueue_scripts', 'dynamicnews_theme_info_page_css' );
