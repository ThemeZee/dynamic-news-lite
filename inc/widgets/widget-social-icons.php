<?php

// Add Social Icons Widget
class Dynamic_News_Social_Icons_Widget extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'dynamicnews_social_icons', 'description' => __('Displays your Social Icons', 'dynamicnews') );
		$this->WP_Widget('dynamicnews_social_icons', 'Social Icons (Dynamic News)', $widget_ops);
	}

	function widget($args, $instance) {

		$cache = wp_cache_get('widget_dynamicnews_social_icons', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

		// Output
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
	?>
		<div class="widget-social-icons social-icons-wrap clearfix">

			<?php dynamicnews_display_social_icons(); ?>

		</div>
	<?php
		echo $after_widget;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_dynamicnews_social_icons', $cache, 'widget');
	}

	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? esc_attr($new_instance['title']) : '';

		$this->flush_widget_cache();

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_dynamicnews_social_icons', 'widget');
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dynamicnews'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
	<?php
	}
}
register_widget('Dynamic_News_Social_Icons_Widget');
?>