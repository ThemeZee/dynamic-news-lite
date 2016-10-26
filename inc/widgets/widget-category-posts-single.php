<?php

// Add Category Posts Single Widget
class Dynamic_News_Category_Posts_Single_Widget extends WP_Widget {

	function __construct() {

		// Setup Widget
		$widget_ops = array(
			'classname' => 'dynamicnews_category_posts_single',
			'description' => esc_html__( 'Displays a single post from a selected category. Please use this widget ONLY in the Magazine Homepage widget area.', 'dynamic-news-lite' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'dynamicnews_category_posts_single', sprintf( esc_html__( 'Category Posts: Single (%s)', 'dynamic-news-lite' ), 'Dynamic News' ), $widget_ops );

		// Delete Widget Cache on certain actions
		add_action( 'save_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'delete_widget_cache' ) );

	}

	public function delete_widget_cache() {

		wp_cache_delete( 'widget_dynamicnews_category_posts_single', 'widget' );

	}

	private function default_settings() {

		$defaults = array(
			'title'				=> '',
			'category'			=> 0,
			'number'			=> 1,
			'category_link'		=> false,
			'postmeta'			=> 4,
		);

		return $defaults;

	}

	// Display Widget
	function widget( $args, $instance ) {

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

		// Get Widget Settings
		$settings = wp_parse_args( $instance, $this->default_settings() );

		// Output
		echo $args['before_widget'];
	?>
		<div id="widget-category-posts-single" class="widget-category-posts clearfix">

			<?php // Display Title
			$this->display_widget_title( $args, $settings ); ?>

			<div class="widget-category-posts-content">

				<?php $this->render( $settings ); ?>

			</div>

		</div>
	<?php
		echo $args['after_widget'];

		// Set Cache
	if ( ! $this->is_preview() ) {
		$cache[ $this->id ] = ob_get_flush();
		wp_cache_set( 'widget_dynamicnews_category_posts_single', $cache, 'widget' );
	} else {
		ob_end_flush();
	}

	}

	// Render Widget Content
	function render( $settings ) {

		// Get latest posts from database
		$query_arguments = array(
			'posts_per_page' => (int) $settings['number'],
			'ignore_sticky_posts' => true,
			'cat' => (int) $settings['category'],
		);
		$posts_query = new WP_Query( $query_arguments );
		$i = 0;

		// Check if there are posts
		if ( $posts_query->have_posts() ) :

			// Display Posts
			while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

					<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'featured_image' ); ?></a>

					<?php the_title( sprintf( '<h2 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

					<?php $this->display_postmeta( $settings ); ?>

					<div class="entry">
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>" class="more-link"><?php esc_html_e( 'Read more', 'dynamic-news-lite' ); ?></a>
					</div>

				</article>

			<?php endwhile;

		endif;

		// Reset Postdata
		wp_reset_postdata();

	}

	// Display Postmeta
	function display_postmeta( $settings ) {

		// Start Output Buffering
		ob_start();

		// Display Date unless deactivated
		if ( $settings['postmeta'] > 0 ) :

			dynamicnews_meta_date();

		endif;

		// Display Author unless deactivated
		if ( 2 === $settings['postmeta'] or 4 === $settings['postmeta'] ) :

			dynamicnews_meta_author();

		endif;

		// Display Comments
		if ( $settings['postmeta'] >= 3 and comments_open() ) :

			dynamicnews_meta_comments();

		endif;

		// Save Output Buffer
		$meta_output = ob_get_contents();

		// Delete Buffer
		ob_end_clean();

		// Only display output if there is postmeta
		if ( false !== $meta_output ) :

			echo '<div class="entry-meta postmeta">' . $meta_output . '</div>';

		endif;

	}

	// Display Widget Title
	function display_widget_title( $args, $settings ) {

		// Add Widget Title Filter
		$widget_title = apply_filters( 'widget_title', $settings['title'], $settings, $this->id_base );

		if ( ! empty( $widget_title ) ) :

			echo $args['before_title'];

			// Link Category Title
			if ( true == $settings['category_link'] ) :

				// Check if "All Categories" is selected
				if ( 0 === $settings['category'] ) :

					$link_title = esc_html__( 'View all posts', 'dynamic-news-lite' );

					// Set Link URL to always point to latest posts page
					if ( get_option( 'show_on_front' ) == 'page' ) :
						$link_url = esc_url( get_permalink( get_option( 'page_for_posts' ) ) );
					else :
						$link_url = esc_url( home_url( '/' ) );
					endif;

				else :

					// Set Link URL and Title for Category
					$link_title = sprintf( esc_html__( 'View all posts from category %s', 'dynamic-news-lite' ), get_cat_name( $settings['category'] ) );
					$link_url = esc_url( get_category_link( $settings['category'] ) );

				endif;

				// Display linked Widget Title
				echo '<a href="' . $link_url . '" title="' . $link_title . '">' . $widget_title . '</a>';
				echo '<a class="category-archive-link" href="' . $link_url . '" title="' . $link_title . '"><span class="genericon-category"></span></a>';

			else :

				echo $widget_title;

			endif;

			echo $args['after_title'];

		endif;

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['category'] = (int) $new_instance['category'];
		$instance['number'] = (int) $new_instance['number'];
		$instance['category_link'] = ! empty( $new_instance['category_link'] );
		$instance['postmeta'] = (int) $new_instance['postmeta'];

		$this->delete_widget_cache();

		return $instance;
	}

	function form( $instance ) {

		// Get Widget Settings
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'dynamic-news-lite' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $settings['title']; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'dynamic-news-lite' ); ?></label><br/>
			<?php // Display Category Select
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'dynamic-news-lite' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category'],
					'name'               => $this->get_field_name( 'category' ),
					'id'                 => $this->get_field_id( 'category' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts:', 'dynamic-news-lite' ); ?>
				<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $settings['number']; ?>" size="3" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category_link' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $settings['category_link'] ); ?> id="<?php echo $this->get_field_id( 'category_link' ); ?>" name="<?php echo $this->get_field_name( 'category_link' ); ?>" />
				<?php esc_html_e( 'Link Widget Title to Category Archive page', 'dynamic-news-lite' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'postmeta' ); ?>"><?php esc_html_e( 'Post Meta:', 'dynamic-news-lite' ); ?></label><br/>
			<select id="<?php echo $this->get_field_id( 'postmeta' ); ?>" name="<?php echo $this->get_field_name( 'postmeta' ); ?>">
				<option value="0" <?php selected( $settings['postmeta'], 0 ); ?>><?php esc_html_e( 'Hide post meta', 'dynamic-news-lite' ); ?></option>
				<option value="1" <?php selected( $settings['postmeta'], 1 ); ?>><?php esc_html_e( 'Display post date', 'dynamic-news-lite' ); ?></option>
				<option value="2" <?php selected( $settings['postmeta'], 2 ); ?>><?php esc_html_e( 'Display date and author', 'dynamic-news-lite' ); ?></option>
				<option value="3" <?php selected( $settings['postmeta'], 3 ); ?>><?php esc_html_e( 'Display date and comments', 'dynamic-news-lite' ); ?></option>
				<option value="4" <?php selected( $settings['postmeta'], 4 ); ?>><?php esc_html_e( 'Display date, author and comments', 'dynamic-news-lite' ); ?></option>
			</select>
		</p>

<?php
	}
}

// Register Widget
add_action( 'widgets_init', 'dynamicnews_register_category_posts_single_widget' );

function dynamicnews_register_category_posts_single_widget() {

	register_widget( 'Dynamic_News_Category_Posts_Single_Widget' );

}
