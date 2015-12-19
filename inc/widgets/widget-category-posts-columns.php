<?php

// Add Category Posts Columns Widget
class Dynamic_News_Category_Posts_Columns_Widget extends WP_Widget {

	function __construct() {
		
		// Setup Widget
		$widget_ops = array(
			'classname' => 'dynamicnews_category_posts_columns', 
			'description' => esc_html__( 'Displays your posts from two selected categories. Please use this widget ONLY in the Magazine Homepage widget area.', 'dynamic-news-lite' )
		);
		parent::__construct('dynamicnews_category_posts_columns', sprintf( esc_html__( 'Category Posts: 2 Columns (%s)', 'dynamic-news-lite' ), 'Dynamic News' ), $widget_ops);
		
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
			'category_two'		=> 0,
			'number'			=> 4,
			'highlight_post'	=> true,
			'category_titles'	=> false,
			'postmeta'			=> 3
		);
		
		return $defaults;
		
	}
	
	// Display Widget
	function widget($args, $instance) {

		$cache = array();
				
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
			
				<?php echo $this->render($args, $instance); ?>
				
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
	function render($args, $instance) {
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );
		
		// Limit the number of words for the excerpt
		add_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length'); ?>
		
		<div class="category-posts-column-left category-posts-columns clearfix">
		
			<?php //Display Category Title
			$this->display_category_title($args, $instance, $category_one); ?>
				
			<?php $this->display_category_posts($instance, $category_one); ?>
			
		</div>
		
		<div class="category-posts-column-right category-posts-columns clearfix">
		
			<?php //Display Category Title
			$this->display_category_title($args, $instance, $category_two); ?>
				
			<?php $this->display_category_posts($instance, $category_two); ?>
			
		</div>
		
		<?php
		// Remove excerpt filter
		remove_filter('excerpt_length', 'dynamicnews_frontpage_category_excerpt_length');
		
	}
	
	// Display Category Posts
	function display_category_posts($instance, $category_id) {
	
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );
		
		// Get latest posts from database
		$query_arguments = array(
			'posts_per_page' => (int)$number,
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
				
				if( $highlight_post == true and (isset($i) and $i == 0) ) : ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('first-post big-post'); ?>>

						<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('category_posts_wide_thumb'); ?></a>

						<?php the_title( sprintf( '<h1 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

						<?php $this->display_postmeta($instance); ?>

						<div class="entry">
							<?php the_excerpt(); ?>
						</div>

					</article>

				<?php else: ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('small-post clearfix'); ?>>

					<?php if ( '' != get_the_post_thumbnail() ) : ?>
						<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('category_posts_small_thumb'); ?></a>
					<?php endif; ?>

						<div class="small-post-content">
							
							<?php the_title( sprintf( '<h1 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
							
							<?php $this->display_postmeta($instance); ?>
						
						</div>

					</article>

				<?php
				endif; $i++;
				
			endwhile; ?>
				
			<?php

		endif;
		
		// Reset Postdata
		wp_reset_postdata();
		
	}
	
	// Display Postmeta
	function display_postmeta( $instance ) {
	
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );
		
		// Start Output Buffering
		ob_start();
		
		// Display Date unless deactivated
		if ( $postmeta > 0 ) :
		
			dynamicnews_meta_date();
					
		endif; 
		
		// Display Author unless deactivated
		if ( $postmeta == 2 ) :	
		
			dynamicnews_meta_author();
		
		endif; 
		
		// Display Comments
		if ( $postmeta == 3 and comments_open() ) :
			
			dynamicnews_meta_comments();
			
		endif;
		
		// Save Output Buffer
		$meta_output = ob_get_contents();
		
		// Delete Buffer
		ob_end_clean();
		
		// Only display output if there is postmeta
		if ( $meta_output <> false ) :
		
			echo '<div class="entry-meta postmeta">' . $meta_output . '</div>';
		
		endif;

	}
	
	// Link Widget Title to Category
	function display_category_title($args, $instance, $category_id) {
		
		// Get Sidebar Arguments
		extract($args);
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );
		
		// Display Category title if activated
		if( $category_titles == true ) : 
				
			echo $before_title;
			
			// Check if "All Categories" is selected
			if( $category_id == 0 ) :
			
				$link_title = esc_html__( 'View all posts', 'dynamic-news-lite' );
				$link_name = esc_html__( 'Latest Posts', 'dynamic-news-lite' );
				
				// Set Link URL to always point to latest posts page
				if ( get_option( 'show_on_front' ) == 'page' ) :
					$link_url = esc_url( get_permalink( get_option('page_for_posts' ) ) );
				else : 
					$link_url =	esc_url( home_url('/') );
				endif;
				
			else :
				
				// Set Link URL and Title for Category
				$link_name = get_cat_name( $category_id );
				$link_title = sprintf( esc_html__( 'View all posts from category %s', 'dynamic-news-lite' ), $link_name );
				$link_url = esc_url( get_category_link( $category_id ) );
				
			endif;
			
			// Display linked Widget Title
			echo '<a href="'. $link_url .'" title="'. $link_title . '">'. $link_name . '</a>';
			echo '<a class="category-archive-link" href="'. $link_url .'" title="'. $link_title . '"><span class="genericon-category"></span></a>';
		
			echo $after_title; 
				
		endif;

	}

	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['category_one'] = (int)$new_instance['category_one'];
		$instance['category_two'] = (int)$new_instance['category_two'];
		$instance['number'] = (int)$new_instance['number'];
		$instance['highlight_post'] = !empty($new_instance['highlight_post']);
		$instance['category_titles'] = !empty($new_instance['category_titles']);
		$instance['postmeta'] = (int)$new_instance['postmeta'];
		
		$this->delete_widget_cache();
		
		return $instance;
	}

	function form( $instance ) {
		
		// Get Widget Settings
		$defaults = $this->default_settings();
		extract( wp_parse_args( $instance, $defaults ) );

?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'dynamic-news-lite' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('category_one'); ?>"><?php esc_html_e( 'Left Category:', 'dynamic-news-lite' ); ?></label><br/>
			<?php // Display Category One Select
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'dynamic-news-lite' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $category_one,
					'name'               => $this->get_field_name('category_one'),
					'id'                 => $this->get_field_id('category_one')
				);
				wp_dropdown_categories( $args ); 
			?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('category_two'); ?>"><?php esc_html_e( 'Right Category:', 'dynamic-news-lite' ); ?></label><br/>
			<?php // Display Category One Select
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'dynamic-news-lite' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $category_two,
					'name'               => $this->get_field_name('category_two'),
					'id'                 => $this->get_field_id('category_two')
				);
				wp_dropdown_categories( $args ); 
			?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of posts:', 'dynamic-news-lite' ); ?>
				<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo (int)$number; ?>" size="3" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('highlight_post'); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $highlight_post ) ; ?> id="<?php echo $this->get_field_id('highlight_post'); ?>" name="<?php echo $this->get_field_name('highlight_post'); ?>" />
				<?php esc_html_e( 'Highlight first post (big image + excerpt)', 'dynamic-news-lite' ); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('category_titles'); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $category_titles ) ; ?> id="<?php echo $this->get_field_id('category_titles'); ?>" name="<?php echo $this->get_field_name('category_titles'); ?>" />
				<?php esc_html_e( 'Display Category Titles', 'dynamic-news-lite' ); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'postmeta' ); ?>"><?php esc_html_e( 'Post Meta:', 'dynamic-news-lite' ); ?></label><br/>
			<select id="<?php echo $this->get_field_id( 'postmeta' ); ?>" name="<?php echo $this->get_field_name( 'postmeta' ); ?>">
				<option value="0" <?php selected($postmeta, 0); ?>><?php esc_html_e( 'Hide post meta', 'dynamic-news-lite' ); ?></option>
				<option value="1" <?php selected($postmeta, 1); ?>><?php esc_html_e( 'Display post date', 'dynamic-news-lite' ); ?></option>
				<option value="2" <?php selected($postmeta, 2); ?>><?php esc_html_e( 'Display date and author', 'dynamic-news-lite' ); ?></option>
				<option value="3" <?php selected($postmeta, 3); ?>><?php esc_html_e( 'Display date and comments', 'dynamic-news-lite' ); ?></option>
			</select>
		</p>
		
<?php
	}
}

// Register Widget
add_action( 'widgets_init', 'dynamicnews_register_category_posts_columns_widget' );

function dynamicnews_register_category_posts_columns_widget() {

	register_widget('Dynamic_News_Category_Posts_Columns_Widget');
	
}