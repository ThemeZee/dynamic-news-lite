<?php
/**
 * Featured Post Slider
 *
 */

// Get our Featured Content posts
$slider_posts = dynamicnews_get_featured_content();

// Check if there is Featured Content
if ( empty( $slider_posts ) ) : ?>

	<p class="frontpage-slider-empty-posts">
		<?php _e('There is no featured content to be displayed in the slider. To set up the slider, go to Appearance → Customize, and add a tag under Tag Name in the Featured Content section. The slideshow will then display all posts which are tagged with that keyword.', 'dynamicnewslite'); ?>
	</p>
	
<?php
	return;
endif;

// Limit the number of words in slideshow post excerpts
add_filter('excerpt_length', 'dynamicnews_slideshow_excerpt_length');

// Display Slider
?>
	<div id="frontpage-slider-wrap" class="clearfix">
		<div id="frontpage-slider" class="zeeflexslider">
			<ul class="zeeslides">

		<?php foreach ( $slider_posts as $post ) : setup_postdata( $post ); ?>

			<li id="slide-<?php the_ID(); ?>" class="zeeslide">

			<?php // Display Post Thumbnail or default thumbnail
				if( '' != get_the_post_thumbnail() ) :

					the_post_thumbnail('slider_image', array('class' => 'slide-image'));

				else: ?>

					<img src="<?php echo get_template_directory_uri(); ?>/images/default-slider-image.png" class="slide-image default-slide-image wp-post-image" alt="default-image" />

			<?php endif;?>

				<div class="slide-entry clearfix">
					<h2 class="slide-title"><a href="<?php esc_url(the_permalink()) ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<div class="slide-content"><?php the_excerpt(); ?></div>
					<a href="<?php esc_url(the_permalink()) ?>" class="slide-more-link"><?php _e('Read more &raquo;', 'dynamicnewslite'); ?></a>
				</div>

			</li>

		<?php endforeach; ?>

			</ul>
		</div>
		<div class="frontpage-slider-controls"></div>
	</div>

<?php
// Remove excerpt filter
remove_filter('excerpt_length', 'dynamicnews_slideshow_excerpt_length');

// Reset Postdata
wp_reset_postdata();

?>