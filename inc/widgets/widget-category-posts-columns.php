<?php

// Add Category Posts Columns Widget
class dynamicnews_Category_Posts_Columns_Widget extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'dynamicnews_category_posts_columns', 'description' => __('Display latest posts from two specified categories. Please use this widget ONLY on Frontpage Magazine widget area.', 'dynamicnewslite') );
		$this->WP_Widget('dynamicnews_category_posts_columns', 'Category Posts Columns (Dynamic News)', $widget_ops);
	}

	function widget($args, $instance) {

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$category_one = empty( $instance['category_one'] ) ? 0 : $instance['category_one'];
		$category_two = empty( $instance['category_two'] ) ? 0 : $instance['category_two'];
		
		// Output
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
	?>
		<div id="widget-category-posts-columns" class="widget-category-posts clearfix">
		
			<?php // Display Category Posts
			if ( $category_one > 0 && $category_two > 0 ) :
			
				dynamicnews_display_category_posts_columns($category_one, $category_two);
				
			else : 
			
				_e( 'Please specify two categories on the Category Posts Widget settings.', 'dynamicnewslite' );
				
			endif;
			?>

		</div>
	<?php
		echo $after_widget;

	}

	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? esc_attr($new_instance['title']) : '';
		$instance['category_one'] = isset($new_instance['category_one']) ? (int)$new_instance['category_one'] : 0;
		$instance['category_two'] = isset($new_instance['category_two']) ? (int)$new_instance['category_two'] : 0;
		
		return $instance;
	}

	function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$category_one = isset($instance['category_one']) ? (int)$instance['category_one'] : 0;
		$category_two = isset($instance['category_two']) ? (int)$instance['category_two'] : 0;
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dynamicnewslite'); ?> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category_one'); ?>"><?php _e('Left Category:', 'dynamicnewslite'); ?><br/>
			
			<?php // Show Dropdown Categories
			$cat_one_args = array( 
				'id' => $this->get_field_id('category_one'), 
				'name' => $this->get_field_name('category_one'), 
				'show_option_none' => ' ', 
				'show_count' => true,
				'selected' => $category_one
			);
			wp_dropdown_categories($cat_one_args); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category_two'); ?>"><?php _e('Right Category:', 'dynamicnewslite'); ?><br/>
			
			<?php // Show Dropdown Categories
			$cat_two_args = array( 
				'id' => $this->get_field_id('category_two'), 
				'name' => $this->get_field_name('category_two'), 
				'show_option_none' => ' ', 
				'show_count' => true,
				'selected' => $category_two
			);
			wp_dropdown_categories($cat_two_args); ?>
			</label>
		</p>
	<?php
	}
}
register_widget('dynamicnews_Category_Posts_Columns_Widget');
?>