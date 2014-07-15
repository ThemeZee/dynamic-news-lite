<?php
/***
 * Header Content
 *
 * This template displays the content in the right-hand header area based on theme options.
 *
 */
 
 
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();

	
	// Display Social Icons
	if ( isset($theme_options['header_icons']) and $theme_options['header_icons'] == true ) : ?>

		<div id="header-social-icons" class="social-icons-wrap clearfix">
			<?php dynamicnews_display_social_icons(); ?>
		</div>

<?php
	endif;
	
	
	// Display Search Form
	if ( isset($theme_options['header_search']) and $theme_options['header_search'] == true ) : ?>

		<div id="header-search">
			<?php get_search_form(true); ?>
		</div>

<?php
	endif;
	
	// Display Text Line
	if ( isset($theme_options['header_text']) and $theme_options['header_text'] <> '' ) : ?>

		<div id="header-text">
			<p><?php echo esc_attr($theme_options['header_text']); ?></p>
		</div>

	<?php
	endif;

?>