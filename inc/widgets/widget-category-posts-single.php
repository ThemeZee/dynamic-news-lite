<?php

// Add Category Posts Single Widget
class Dynamic_News_Category_Posts_Single_Widget extends WP_Widget {

	function __construct() {
		
		// Setup Widget
		$widget_ops = array(
			'classname' => 'dynamicnews_category_posts_single', 
			'description' => __('Displays a single post from a selected category. Please use this widget ONLY in the Magazine Homepage widget area.', 'dynamic-news-lite')
		);
		parent::__construct('dynamicnews_category_posts_single', sprintf( __('Category Posts: Single (%s)', 'dynamic-news-lite'), 'Dynamic News' ), $widget_ops);
		
		// Delete Widget Cache on certain actions
		add_action( 'save_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'delete_widget_cache' ) );
		
	}

	public function delete_widget_cache() {
		
		wp_cache_delete('widget_dynamicnews_category_posts_single', 'widget');
		
	}
	
	private function default_settings() {
	
		$defaults = array(
			'title'				=> '',
			'category'			=> 0,
			'number'			=> 1,
			'category_link'		=> false
		);
		
		return $defaults;
		
	}
	
	// Display Widget
	function widget($args, $instance) {

		$cache = array();
				
		// Get Widget Object Cache
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_dynamicnews_category_posts_single', 'widget' );
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
			
		// Extract Sidebar Arguments
		extract($args);
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );
		
		// Output
		echo $before_widget;
	?>
		<div id="widget-category-posts-single" class="widget-category-posts clearfix">

			<?php // Display Title
			$this->display_widget_title($args, $instance); ?>
			
			<div class="widget-category-posts-content">
			
				<?php $this->render($instance); ?>
				
			</div>
			
		</div>
	<?php
		echo $after_widget;
		
		// Set Cache
		if ( ! $this->is_preview() ) {
			$cache[ $this->id ] = ob_get_flush();
			wp_cache_set( 'widget_dynamicnews_category_posts_single', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	
	}
	
	// Render Widget Content
	function render($instance) {
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );
		
		// Get latest posts from database
		$query_arguments = array(
			'posts_per_page' => (int)$number,
			'ignore_sticky_posts' => true,
			'cat' => (int)$category
		);
		$posts_query = new WP_Query($query_arguments);
		$i = 0;

		// Check if there are posts
		if( $posts_query->have_posts() ) :
		
			// Display Posts
			while( $posts_query->have_posts() ) : $posts_query->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>

					<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('featured_image'); ?></a>

					<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>

					<div class="postmeta"><?php dynamicnews_display_postmeta(); ?></div>

					<div class="entry">
						<?php the_excerpt(); ?>
						<a href="<?php esc_url(the_permalink()) ?>" class="more-link"><?php _e('Read more', 'dynamic-news-lite'); ?></a>
					</div>

				</article>

			<?php endwhile;
			
		endif;
		
		// Reset Postdata
		wp_reset_postdata();

	}
	
	// Display Widget Title
	function display_widget_title($args, $instance) {
		
		// Get Sidebar Arguments
		extract($args);
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );
		
		// Add Widget Title Filter
		$widget_title = apply_filters('widget_title', $title, $instance, $this->id_base);
		
		if( !empty( $widget_title ) ) :
		
			echo $before_title;
			
			// Link Category Title
			if( $category_link == true ) : 
			
				// Check if "All Categories" is selected
				if( $category == 0 ) :
				
					$link_title = __('View all posts', 'dynamic-news-lite');
					
					// Set Link URL to always point to latest posts page
					if ( get_option( 'show_on_front' ) == 'page' ) :
						$link_url = esc_url( get_permalink( get_option('page_for_posts' ) ) );
					else : 
						$link_url =	esc_url( home_url('/') );
					endif;
					
				else :
					
					// Set Link URL and Title for Category
					$link_title = sprintf( __('View all posts from category %s', 'dynamic-news-lite'), get_cat_name( $category ) );
					$link_url = esc_url( get_category_link( $category ) );
					
				endif;
				
				// Display linked Widget Title
				echo '<a href="'. $link_url .'" title="'. $link_title . '">'. $widget_title . '</a>';
				echo '<a class="category-archive-link" href="'. $link_url .'" title="'. $link_title . '"><span class="genericon-category"></span></a>';
			
			else:
			
				echo $widget_title;
			
			endif;
			
			echo $after_title; 
			
		endif;

	}

	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['category'] = (int)$new_instance['category'];
		$instance['number'] = (int)$new_instance['number'];
		$instance['category_link'] = !empty($new_instance['category_link']);
		
		$this->delete_widget_cache();
		
		return $instance;
	}

	function form( $instance ) {
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );

?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dynamic-news-lite'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'dynamic-news-lite'); ?></label><br/>
			<?php // Display Category Select
				$args = array(
					'show_option_all'    => __('All Categories', 'dynamic-news-lite'),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $category,
					'name'               => $this->get_field_name('category'),
					'id'                 => $this->get_field_id('category')
				);
				wp_dropdown_categories( $args ); 
			?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:', 'dynamic-news-lite'); ?>
				<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('category_link'); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $category_link ) ; ?> id="<?php echo $this->get_field_id('category_link'); ?>" name="<?php echo $this->get_field_name('category_link'); ?>" />
				<?php _e('Link Widget Title to Category Archive page', 'dynamic-news-lite'); ?>
			</label>
		</p>
		
<?php
	}
}

// Register Widget
add_action( 'widgets_init', 'dynamicnews_register_category_posts_single_widget' );

function dynamicnews_register_category_posts_single_widget() {

	register_widget('Dynamic_News_Category_Posts_Single_Widget');
	
}