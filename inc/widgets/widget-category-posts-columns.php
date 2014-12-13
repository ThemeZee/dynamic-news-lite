<?php

// Add Category Posts Columns Widget
class Dynamic_News_Category_Posts_Columns_Widget extends WP_Widget {

	function __construct() {
		
		// Setup Widget
		$widget_ops = array(
			'classname' => 'dynamicnews_category_posts_columns', 
			'description' => __('Display latest posts from two specified categories. Please use this widget ONLY on Frontpage Magazine widget area.', 'dynamicnewslite')
		);
		$this->WP_Widget('dynamicnews_category_posts_columns', __('Category Posts Columns (Dynamic News)', 'dynamicnewslite'), $widget_ops);
		
		// Delete Widget Cache on certain actions
		add_action( 'save_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'delete_widget_cache' ) );
		
	}

	public function delete_widget_cache() {
		
		wp_cache_delete('widget_dynamicnews_category_posts_columns', 'widget');
		
	}
	
	private function default_settings() {
	
		$defaults = array(
			'title'				=> '',
			'category_one'		=> 0,
			'category_two'		=> 0
		);
		
		return $defaults;
		
	}
	
	// Display Widget
	function widget($args, $instance) {

		// Get Widget Object Cache
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_dynamicnews_category_posts_columns', 'widget' );
		}
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		// Display Widget from Cache if exists
		if ( isset( $cache[ $this->id ] ) ) {
			echo $cache[ $this->id ];
			return;
		}
		
		// Start Output Buffering
		ob_start();
		
		// Get Sidebar Arguments
		extract($args);
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );
		
		// Add Widget Title Filter
		$widget_title = apply_filters('widget_title', $title, $instance, $this->id_base);
		
		// Output
		echo $before_widget;
	?>
		<div id="widget-category-posts-columns" class="widget-category-posts clearfix">
		
			<?php // Display Title
			if( !empty( $widget_title ) ) { echo $before_title . $widget_title . $after_title; }; ?>
			
			<div class="widget-category-posts-content">
			
				<?php echo $this->render($instance); ?>
				
			</div>
			
		</div>
	<?php
		echo $after_widget;
		
		// Set Cache
		if ( ! $this->is_preview() ) {
			$cache[ $this->id ] = ob_get_flush();
			wp_cache_set( 'widget_dynamicnews_category_posts_columns', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	
	}
	
	// Render Widget Content
	function render($instance) {
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );
		
		// Limit the number of words for the excerpt
		add_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length'); ?>
		
		<div class="category-posts-column-left category-posts-columns">
		
			<?php $this->display_category_posts($instance, $category_one); ?>
			
		</div>
		
		<div class="category-posts-column-right category-posts-columns">
		
			<?php $this->display_category_posts($instance, $category_two); ?>
			
		</div>
		
		<?php
		// Remove excerpt filter
		remove_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length');
		
	}
	
	// Display Category Posts
	function display_category_posts($instance, $category_id) {
	
		// Get latest posts from database
		$query_arguments = array(
			'posts_per_page' => 4,
			'ignore_sticky_posts' => true,
			'cat' => (int)$category_id
		);
		$posts_query = new WP_Query($query_arguments);
		$i = 0;

		// Check if there are posts
		if( $posts_query->have_posts() ) :
		
			// Display Posts
			while( $posts_query->have_posts() ) :
				
				$posts_query->the_post(); 
				
				if(isset($i) and $i == 0) : ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('first-post'); ?>>

						<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('category_posts_wide_thumb'); ?></a>

						<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>

						<div class="postmeta"><?php $this->display_postmeta($instance); ?></div>

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
							<div class="postmeta"><?php $this->display_postmeta($instance); ?></div>
						</div>

					</article>

				<?php
				endif; $i++;
				
			endwhile; ?>
			
				</div><!-- end .more-posts -->
				
			<?php

		endif;
		
		// Reset Postdata
		wp_reset_postdata();
		
	}
	
	// Display Postmeta
	function display_postmeta($instance) { ?>

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

	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['category_one'] = (int)$new_instance['category_one'];
		$instance['category_two'] = (int)$new_instance['category_two'];
		
		$this->delete_widget_cache();
		
		return $instance;
	}

	function form( $instance ) {
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );

?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dynamicnewslite'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('category_one'); ?>"><?php _e('Left Category:', 'dynamicnewslite'); ?></label><br/>
			<?php // Display Category One Select
				$args = array(
					'show_option_all'    => __('All Categories', 'dynamicnewslite'),
					'show_count' 		 => true,
					'selected'           => $category_one,
					'name'               => $this->get_field_name('category_one'),
					'id'                 => $this->get_field_id('category_one')
				);
				wp_dropdown_categories( $args ); 
			?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('category_two'); ?>"><?php _e('Right Category:', 'dynamicnewslite'); ?></label><br/>
			<?php // Display Category One Select
				$args = array(
					'show_option_all'    => __('All Categories', 'dynamicnewslite'),
					'show_count' 		 => true,
					'selected'           => $category_two,
					'name'               => $this->get_field_name('category_two'),
					'id'                 => $this->get_field_id('category_two')
				);
				wp_dropdown_categories( $args ); 
			?>
		</p>
		
<?php
	}
}
register_widget('Dynamic_News_Category_Posts_Columns_Widget');
?>