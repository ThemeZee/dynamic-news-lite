<?php
// Add ThemeZee Recent Comments Widget
class Dynamic_News_Recent_Comments_Widget extends WP_Widget {

	var $comment_length = 40;
	
	function __construct() {
		$widget_ops = array('classname' => 'dynamicnews_recent_comments', 'description' => __('Show recent comments with gravatar.', 'dynamicnews') );
		$this->WP_Widget('dynamicnews_recent_comments', 'Recent Comments (Dynamic News)', $widget_ops);

		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
	}

	function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = wp_cache_get('widget_dynamicnews_recent_comments', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

 		extract($args, EXTR_SKIP);
 		$output = '';
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 5;
			
		$avatar = (int)$instance['avatar'];
		$post_title = (int)$instance['post_title'];
		$comment_content = (int)$instance['comment_content'];
		$comment_length = $this->comment_length = empty( $instance['comment_length'] ) ? 0 : $instance['comment_length'];
		$comment_date = (int)$instance['comment_date'];
		
		$comments = get_comments( apply_filters( 'dynamicnews_widget_comments_args', array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish' ) ) );
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<div class="widget-recent-comments">';
		$output .= '<ul>';
		if ( $comments ) {
			foreach ( (array) $comments as $comment) {
				
				if ( $avatar == 1 ) :
					$output .= '<li class="widget-avatar"><a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_avatar( $comment, 55 ) . '</a>';
				else:
					$output .= '<li>';
				endif;
				
				if ( $post_title == 1 ) :
					$output .= get_comment_author_link();
					$output .= __(' on', 'dynamicnews') . ' <a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>';
				else:
					$output .= '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_comment_author_link() . '</a>';

				endif;
				if ( $comment_content == 1 ) :
					$output .= __(' said:', 'dynamicnews') . ' <span class="comment-content">' . $this->widget_comment_length($comment->comment_content) . '</span> ';
				endif;
				if ( $comment_date == 1 ) :
					$output .= '<div class="comment-date">' . date('M d H:i', strtotime($comment->comment_date)) . '</div>';
				endif;
				$output .= '</li>';
			}
 		}
		$output .= '</ul>';
		$output .= '</div>';
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_dynamicnews_recent_comments', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? esc_attr($new_instance['title']) : '';
		$instance['number'] = (int) $new_instance['number'];
		$instance['avatar'] = $new_instance['avatar'] ? 1 : 0;
		$instance['post_title'] = $new_instance['post_title'] ? 1 : 0;
		$instance['comment_content'] = $new_instance['comment_content'] ? 1 : 0;
		$instance['comment_length'] = (int) $new_instance['comment_length'];
		$instance['comment_date'] = $new_instance['comment_date'] ? 1 : 0;
		
		$this->flush_widget_cache();

		return $instance;
	}
	
	function widget_comment_length($comment) {
		$parts = explode("\n", wordwrap($comment, $this->comment_length, "\n"));
		return $parts[0];
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_dynamicnews_recent_comments', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$avatar = (isset($instance['avatar']) and $instance['avatar'] == 1) ? 'checked="checked"' : '';
		$post_title = (isset($instance['post_title']) and $instance['post_title'] == 1) ? 'checked="checked"' : '';
		$comment_content = (isset($instance['comment_content']) and $instance['comment_content'] == 1) ? 'checked="checked"' : '';
		$comment_length = isset($instance['comment_length']) ? absint($instance['comment_length']) : 40;
		$comment_date = (isset($instance['comment_date']) and $instance['comment_date'] == 1) ? 'checked="checked"' : '';
		
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dynamicnews'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:', 'dynamicnews'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		<p><input class="checkbox" type="checkbox" <?php echo $avatar; ?> id="<?php echo $this->get_field_id('avatar'); ?>" name="<?php echo $this->get_field_name('avatar'); ?>" />
		<label for="<?php echo $this->get_field_id('avatar'); ?>"><?php _e('Show avatar of comment author?', 'dynamicnews'); ?></label></p>
		
		<p><input class="checkbox" type="checkbox" <?php echo $post_title; ?> id="<?php echo $this->get_field_id('post_title'); ?>" name="<?php echo $this->get_field_name('post_title'); ?>" />
		<label for="<?php echo $this->get_field_id('post_title'); ?>"><?php _e('Show post title of commented post?', 'dynamicnews'); ?></label></p>
		
		<p><input class="checkbox" type="checkbox" <?php echo $comment_content; ?> id="<?php echo $this->get_field_id('comment_content'); ?>" name="<?php echo $this->get_field_name('comment_content'); ?>" />
		<label for="<?php echo $this->get_field_id('comment_content'); ?>"><?php _e('Show excerpt of comment?', 'dynamicnews'); ?></label></p>
		
		<p><label for="<?php echo $this->get_field_id('comment_length'); ?>"><?php _e('Excerpt length in number of characters:', 'dynamicnews'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('comment_length'); ?>" name="<?php echo $this->get_field_name('comment_length'); ?>" type="text" value="<?php echo $comment_length; ?>" /></p>

		<p><input class="checkbox" type="checkbox" <?php echo $comment_date; ?> id="<?php echo $this->get_field_id('comment_date'); ?>" name="<?php echo $this->get_field_name('comment_date'); ?>" />
		<label for="<?php echo $this->get_field_id('comment_date'); ?>"><?php _e('Show date of comment?', 'dynamicnews'); ?></label></p>
		
<?php
	}
}
register_widget('Dynamic_News_Recent_Comments_Widget');
?>