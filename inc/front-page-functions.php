<?php
/***
 * Front Page Template Functions
 *
 * This file contains several template functions which are used to print out specific HTML markup
 * on the front page magazine template of the theme.
 *
 */

 // Display boxed category posts  on frontpage magazine template
function dynamicnews_display_category_posts_boxed($category) {

	// Limit the number of words in slideshow post excerpts
	add_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length');

	// Get Query Arguments for Category Posts
	$query_arguments = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'showposts' => 4,
		'ignore_sticky_posts' => true,
		'orderby' => 'date',
		'cat' => (int)$category
	);
	$category_posts_boxed_query = new WP_Query($query_arguments);
	$i = 0;

	// Display Category Posts
	if ($category_posts_boxed_query->have_posts()) : while ($category_posts_boxed_query->have_posts()) : $category_posts_boxed_query->the_post(); $i++;

			dynamicnews_display_category_loop($i);

		endwhile;

		echo '</div>';

	endif;

	// Reset Postdata
	wp_reset_postdata();

	// Remove excerpt filter
	remove_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length');

}


// Display 2 columns category posts
function dynamicnews_display_category_posts_columns($category_one, $category_two) {

	// Limit the number of words in slideshow post excerpts
	add_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length');

	// Get Query Arguments for Category One
	$query_arguments = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'showposts' => 4,
		'ignore_sticky_posts' => true,
		'orderby' => 'date',
		'cat' => (int)$category_one
	);
	$category_posts_column_left_query = new WP_Query($query_arguments);
	$i = 0; $j = 0;
?>

	<div class="category-posts-column-left category-posts-columns">

		<?php // Display Posts form Category Left
		if ($category_posts_column_left_query->have_posts()) : 
		
			while ($category_posts_column_left_query->have_posts()) : $category_posts_column_left_query->the_post(); $i++;

				dynamicnews_display_category_loop($i);

			endwhile;

			echo '</div>';

		endif; ?>

	<?php wp_reset_postdata(); ?>

	</div>

<?php
		
	// Get Query Arguments for Category Two
	$query_arguments = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'showposts' => 4,
		'ignore_sticky_posts' => true,
		'orderby' => 'date',
		'cat' => (int)$category_two
	);
	$category_posts_column_right_query = new WP_Query($query_arguments);
	$i = 0; $j = 0;
?>
	
	<div class="category-posts-column-right category-posts-columns">

		<?php // Display posts from Category Right 
		if ($category_posts_column_right_query->have_posts()) : 
		
			while ($category_posts_column_right_query->have_posts()) : $category_posts_column_right_query->the_post(); $j++;

				dynamicnews_display_category_loop($j);

			endwhile;

			echo '</div>';

		endif; ?>

	<?php wp_reset_postdata(); ?>

	</div>

<?php
	
	// Remove excerpt filter
	remove_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length');

}


// Display grid posts from category  on frontpage magazine template
function dynamicnews_display_category_posts_grid($category, $count = 4) {

	// Limit the number of words in slideshow post excerpts
	add_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length');

	// Get Query Arguments for Category Posts
	$query_arguments = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'showposts' => (int)$count,
		'ignore_sticky_posts' => true,
		'orderby' => 'date',
		'cat' => (int)$category
	);
	$category_posts_grid_query = new WP_Query($query_arguments);
	$i = 0;

	// Display Category Posts
	if ($category_posts_grid_query->have_posts()) : while ($category_posts_grid_query->have_posts()) : $category_posts_grid_query->the_post(); ?>

			<?php // Open new Row on the Grid
			if ( $i % 2 == 0) : ?>
				<div class="category-posts-grid-row clearfix">
			<?php // Set Variable row_open to true
				$row_open = true;
			endif; ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('category_posts_wide_thumb'); ?></a>

					<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>

					<div class="postmeta"><?php dynamicnews_display_postmeta_frontpage(); ?></div>

					<div class="entry">
						<?php the_excerpt(); ?>
					</div>

				</article>

			<?php // Close Row on the Grid
			if ( $i % 2 == 1) : ?>
				</div>
			<?php // Set Variable row_open to false
				$row_open = false;
			endif; $i++; ?>

	<?php 
		
		endwhile;
		
		// Make sure row is always closed
		if ( $row_open == true) : ?>
			</div>
<?php 	endif;

	 endif;

	// Reset Postdata
	wp_reset_postdata();

	// Remove excerpt filter
	remove_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length');

}


// Display Frontpage Category Postmeta Data
function dynamicnews_display_postmeta_frontpage() { ?>

	<span class="meta-date">
	<?php printf('<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s">%4$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
	?>
	</span>

<?php if ( comments_open() ) : ?>
	<span class="meta-comments sep">
		<?php comments_popup_link( __('Leave a comment', 'dynamicnewslite'),__('One comment','dynamicnewslite'),__('% comments','dynamicnewslite') ); ?>
	</span>
<?php endif;

}


// Display boxed category posts on frontpage magazine template
function dynamicnews_display_category_loop($i) {

	global $post;

	if(isset($i) and $i == 1) : ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('first-post'); ?>>

			<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('category_posts_wide_thumb'); ?></a>

			<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>

			<div class="postmeta"><?php dynamicnews_display_postmeta_frontpage(); ?></div>

			<div class="entry">
				<?php the_excerpt(); ?>
			</div>

		</article>

	<div class="more-posts clearfix">

	<?php else: ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

		<?php if ( '' != get_the_post_thumbnail() ) : ?>
			<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('category_posts_small_thumb'); ?></a>
		<?php endif; ?>

			<div class="more-posts-content">
				<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="postmeta"><?php dynamicnews_display_postmeta_frontpage(); ?></div>
			</div>

		</article>

	<?php endif;

}


?>