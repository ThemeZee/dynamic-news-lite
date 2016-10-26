<?php
/**
 * Featured Post Slider
 *
 */

// Get our Featured Content posts
$slider_posts = dynamicnews_get_featured_content();

// Check if there is Featured Content
if ( empty( $slider_posts ) and current_user_can( 'edit_theme_options' ) ) : ?>

	<p class="frontpage-slider-empty-posts">
		<?php esc_html_e( 'There is no featured content to be displayed in the slider. To set up the slider, go to Appearance &#8594; Customize &#8594; Theme Options, and add a featured tag in the Post Slider section. The slideshow displays all your posts which are tagged with that keyword.', 'dynamic-news-lite' ); ?>
	</p>

<?php
	return;
endif;

// Limit the number of words in slideshow post excerpts
add_filter( 'excerpt_length', 'dynamicnews_slideshow_excerpt_length' );

// Display Slider
?>
	<div id="frontpage-slider-wrap" class="clearfix">
		<div id="frontpage-slider" class="zeeflexslider">
			<ul class="zeeslides">

		<?php foreach ( $slider_posts as $post ) : setup_postdata( $post ); ?>

			<li id="slide-<?php the_ID(); ?>" class="zeeslide">

			<?php // Display Post Thumbnail or default thumbnail
			if ( '' != get_the_post_thumbnail() ) :

				the_post_thumbnail( 'slider_image', array( 'class' => 'slide-image' ) );

				else : ?>

					<img src="<?php echo get_template_directory_uri(); ?>/images/default-slider-image.png" class="slide-image default-slide-image wp-post-image" alt="default-image" />

			<?php endif;?>

				<div class="slide-entry clearfix">
					<?php the_title( sprintf( '<h2 class="slide-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
					<div class="slide-content"><?php the_excerpt(); ?></div>
					<a href="<?php the_permalink(); ?>" class="slide-more-link"><?php esc_html_e( 'Read more &raquo;', 'dynamic-news-lite' ); ?></a>
				</div>

			</li>

		<?php endforeach; ?>

			</ul>
		</div>
		<div class="frontpage-slider-controls"></div>
	</div>

<?php
// Remove excerpt filter
remove_filter( 'excerpt_length', 'dynamicnews_slideshow_excerpt_length' );

// Reset Postdata
wp_reset_postdata();

?>
