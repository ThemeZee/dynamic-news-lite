<?php
/***
 * Header Content
 *
 * This template displays the content in the right-hand header area based on theme options.
 *
 */

// Get Theme Options from Database
$theme_options = dynamicnews_theme_options();

// Display Header Widgets
if ( is_active_sidebar( 'header' ) ) : ?>

	<div class="header-widgets clearfix">
		<?php dynamic_sidebar( 'header' ); ?>
	</div><!-- .header-widgets -->

<?php
endif;

// Display Social Icons
if ( true == $theme_options['header_icons'] ) : ?>

	<div id="header-social-icons" class="social-icons-wrap clearfix">
		<?php dynamicnews_display_social_icons(); ?>
	</div>

<?php
endif;

// Display Search Form.
if ( true == $theme_options['header_search'] ) : ?>

	<div id="header-search">
		<?php get_search_form( true ); ?>
	</div>

<?php
endif;

// Display Text Line
if ( '' !== $theme_options['header_text'] ) : ?>

	<div id="header-text">
		<p><?php echo esc_html( $theme_options['header_text'] ); ?></p>
	</div>

<?php
endif;
