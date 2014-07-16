<?php

// Add Category Posts Boxed Widget
class dynamicnews_Category_Posts_Boxed_Widget extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'dynamicnews_category_posts_boxed', 'description' => __('Display latest posts from category in boxed layout. Please use this widget ONLY on Frontpage Magazine widget area.', 'dynamicnewslite') );
		$this->WP_Widget('dynamicnews_category_posts_boxed', 'Category Posts Boxed (Dynamic News)', $widget_ops);
	}

	function widget($args, $instance) {

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$category = empty( $instance['category'] ) ? 0 : $instance['category'];
		
		// Output
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
	?>
		<div id="widget-category-posts-boxed" class="widget-category-posts clearfix">
		
			<?php // Display Category Posts
			if ( $category > 0 ) :
			
				dynamicnews_display_category_posts_boxed($category);
				
			else : 
			
				_e( 'Please specify a category on the Category Posts Widget settings.', 'dynamicnewslite' );
				
			endif;
			?>

		</div>
	<?php
		echo $after_widget;

	}

	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? esc_attr($new_instance['title']) : '';
		$instance['category'] = isset($new_instance['category']) ? (int)$new_instance['category'] : 0;

		return $instance;
	}

	function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$category = isset($instance['category']) ? (int)$instance['category'] : 0;
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dynamicnewslite'); ?> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'dynamicnewslite'); ?><br/>
			
			<?php // Show Dropdown Categories
			$cat_args = array( 
				'id' => $this->get_field_id('category'), 
				'name' => $this->get_field_name('category'), 
				'show_option_none' => ' ', 
				'show_count' => true,
				'selected' => $category
			);
			wp_dropdown_categories($cat_args); ?>
			</label>
		</p>
	<?php
	}
}
register_widget('dynamicnews_Category_Posts_Boxed_Widget');
?>