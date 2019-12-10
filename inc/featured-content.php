<?php
/**
 * Dynamic News Featured Content
 *
 * This module will allow users to define a subset of posts to be displayed in a
 * theme-designated featured content area.
 *
 * For maximum compatibility with different methods of posting users will
 * designate a featured post tag to associate posts with. Since this tag now has
 * special meaning beyond that of a normal tags, users will have the ability to
 * hide it from the front-end of their site.
 *
 *
 *
 * Original Code: Twenty Fourteen http://wordpress.org/themes/twentyfourteen
 * Original Copyright: the WordPress team and contributors.
 *
 * The following code is a derivative work of the code from the Twenty Fourteen theme,
 * which is licensed GPLv2. This code therefore is also licensed under the terms
 * of the GNU Public License, version 2.
 */

class Dynamic_News_Featured_Content {

	/**
	 * Instantiate.
	 *
	 * All custom functionality will be hooked into the "init" action.
	 */
	public static function setup() {
		add_action( 'init', array( __CLASS__, 'init' ), 30 );
	}

	/**
	 * Conditionally hook into WordPress.
	 *
	 */
	public static function init() {

		add_filter( 'dynamicnews_get_featured_content',   array( __CLASS__, 'get_featured_posts' ) );
		add_action( 'customize_register',                 array( __CLASS__, 'customize_register' ), 9 );
		add_action( 'admin_init',                         array( __CLASS__, 'register_setting' ) );
		add_action( 'save_post',                          array( __CLASS__, 'delete_transient' ) );
		add_action( 'delete_post_tag',                    array( __CLASS__, 'delete_post_tag' ) );
		add_action( 'customize_controls_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'pre_get_posts',                      array( __CLASS__, 'pre_get_posts' ) );
		add_action( 'switch_theme',                       array( __CLASS__, 'delete_transient' ) );
	}

	/**
	 * Get featured posts
	 *
	 * @uses Dynamic_News_Featured_Content::get_featured_post_ids()
	 *
	 * @return array
	 */
	public static function get_featured_posts() {
		$post_ids = self::get_featured_post_ids();

		// No need to query if there is are no featured posts.
		if ( empty( $post_ids ) ) {
			return array();
		}

		$featured_posts = get_posts( array(
			'include'        => $post_ids,
			'posts_per_page' => count( $post_ids ),
		) );

		return $featured_posts;
	}

	/**
	 * Get featured post IDs
	 *
	 * This function will return the an array containing the post IDs of all
	 * featured posts.
	 *
	 * Sets the "featured_content_ids" transient.
	 *
	 * @return array Array of post IDs.
	 */
	public static function get_featured_post_ids() {

		// Return array of cached results if they exist.
		$featured_ids = get_transient( 'featured_content_ids' );
		if ( ! empty( $featured_ids ) ) {
			return array_map( 'absint', apply_filters( 'dynamicnews_featured_content_post_ids', (array) $featured_ids ) );
		}

		$settings = self::get_setting();

		// Return empty array if no tag name is set.
		$term = get_term_by( 'name', $settings['tag-name'], 'post_tag' );
		if ( ! $term ) {
			$term = get_term_by( 'id', $settings['tag-id'], 'post_tag' );
		}
		if ( $term ) {
			$tag = $term->term_id;
		} else {
			return apply_filters( 'dynamicnews_featured_content_post_ids', array() );
		}

		// Query for featured posts.
		$featured = get_posts( array(
			'numberposts' => absint( $settings['max-posts'] ),
			'tax_query'   => array(
				array(
					'field'    => 'term_id',
					'taxonomy' => 'post_tag',
					'terms'    => $tag,
				),
			),
		) );

		// Return empty array if no featured content exists.
		if ( ! $featured ) {
			return apply_filters( 'dynamicnews_featured_content_post_ids', array() );
		}

		// Ensure correct format before save/return.
		$featured_ids = wp_list_pluck( (array) $featured, 'ID' );
		$featured_ids = array_map( 'absint', $featured_ids );

		set_transient( 'featured_content_ids', $featured_ids );

		return apply_filters( 'dynamicnews_featured_content_post_ids', $featured_ids );
	}

	/**
	 * Delete Transient.
	 *
	 * Hooks in the "save_post" action.
	 * @see Dynamic_News_Featured_Content::validate_settings().
	 */
	public static function delete_transient() {
		delete_transient( 'featured_content_ids' );
	}

	/**
	 * Exclude featured posts from the blog query when the blog is the front-page,
	 * and user has not checked the "Display tag content in all listings" checkbox.
	 *
	 * Filter the home page posts, and remove any featured post ID's from it.
	 * Hooked onto the 'pre_get_posts' action, this changes the parameters of the
	 * query before it gets any posts.
	 *
	 * @uses Dynamic_News_Featured_Content::get_featured_post_ids();
	 * @uses Dynamic_News_Featured_Content::get_setting();
	 * @param WP_Query $query
	 * @return WP_Query Possibly modified WP_Query
	 */
	public static function pre_get_posts( $query ) {

		// Bail if not home or not main query.
		if ( ! $query->is_home() || ! $query->is_main_query() ) {
			return;
		}

		// Bail if the blog page is not the front page.
		if ( 'posts' !== get_option( 'show_on_front' ) ) {
			return;
		}

		$featured = self::get_featured_post_ids();

		// Bail if no featured posts.
		if ( ! $featured ) {
			return;
		}

		$settings = self::get_setting();

		// Bail if the user wants featured posts always displayed.
		if ( true == $settings['show-all'] ) {
			return;
		}

		// We need to respect post ids already in the blacklist.
		$post__not_in = $query->get( 'post__not_in' );

		if ( ! empty( $post__not_in ) ) {
			$featured = array_merge( (array) $post__not_in, $featured );
			$featured = array_unique( $featured );
		}

		$query->set( 'post__not_in', $featured );
	}

	/**
	 * Reset tag option when the saved tag is deleted.
	 *
	 * It's important to mention that the transient needs to be deleted, too.
	 * While it may not be obvious by looking at the function alone, the transient
	 * is deleted by Dynamic_News_Featured_Content::validate_settings().
	 *
	 * Hooks in the "delete_post_tag" action.
	 * @see Dynamic_News_Featured_Content::validate_settings().
	 *
	 * @param int $tag_id The term_id of the tag that has been deleted.
	 * @return void
	 */
	public static function delete_post_tag( $tag_id ) {
		$settings = self::get_setting();

		if ( empty( $settings['tag-id'] ) || $tag_id != $settings['tag-id'] ) {
			return;
		}

		$settings['tag-id'] = 0;
		$settings = self::validate_settings( $settings );
		update_option( 'featured-content', $settings );
	}

	/**
	 * Register custom setting on the Settings -> Reading screen.
	 *
	 * @uses Dynamic_News_Featured_Content::validate_settings()
	 *
	 * @return void
	 */
	public static function register_setting() {

		// Register sanitization callback for the Customizer.
		register_setting( 'featured-content', 'featured-content', array( __class__, 'validate_settings' ) );
	}

	/**
	 * Add settings to the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function customize_register( $wp_customize ) {

		/* Add Featured Content settings.
		 *
		 * Sanitization callback registered in Dynamic_News_Featured_Content::validate_settings().
		 * See http://themeshaper.com/2013/04/29/validation-sanitization-in-customizer/comment-page-1/#comment-12374
		 */
		$wp_customize->add_setting( 'featured-content[tag-name]', array(
			'type'                 => 'option',
			'sanitize_js_callback' => array( __CLASS__, 'delete_transient' ),
		) );
		$wp_customize->add_setting( 'featured-content[show-all]', array(
			'default'              => false,
			'type'                 => 'option',
			'sanitize_js_callback' => array( __CLASS__, 'delete_transient' ),
		) );
		$wp_customize->add_setting( 'featured-content[max-posts]', array(
			'default'              => 20,
			'type'                 => 'option',
			'sanitize_js_callback' => array( __CLASS__, 'delete_transient' ),
		) );

		// Add Featured Content controls.
		$wp_customize->add_control( 'featured-content[tag-name]', array(
			'label'          => esc_html__( 'Tag name', 'dynamic-news-lite' ),
			'section'        => 'dynamicnews_section_slider',
			'priority'       => 5,
			'active_callback' => 'dynamicnews_slider_activated_callback',
		) );
		$wp_customize->add_control( 'featured-content[show-all]', array(
			'label'          => esc_html__( 'Display featured posts in latest blog post listing.', 'dynamic-news-lite' ),
			'section'        => 'dynamicnews_section_slider',
			'type'           => 'checkbox',
			'priority'       => 7,
			'active_callback' => 'dynamicnews_slider_activated_callback',
		) );
		$wp_customize->add_control( 'featured-content[max-posts]', array(
			'label'          => esc_html__( 'Number of Posts', 'dynamic-news-lite' ),
			'section'        => 'dynamicnews_section_slider',
			'type'           => 'text',
			'priority'       => 9,
			'active_callback' => 'dynamicnews_slider_activated_callback',
		) );
	}

	/**
	 * Enqueue the tag suggestion script.
	 */
	public static function enqueue_scripts() {
		wp_enqueue_script( 'dynamicnews-featured-content-suggest', get_template_directory_uri() . '/js/featured-content-admin.js', array( 'jquery', 'suggest' ), '20150401', true );
	}

	/**
	 * Get settings
	 *
	 * Get all settings recognized by this module. This function will return all
	 * settings whether or not they have been stored in the database yet. This
	 * ensures that all keys are available at all times.
	 *
	 * In the event that you only require one setting, you may pass its name as the
	 * first parameter to the function and only that value will be returned.
	 *
	 * @param string $key The key of a recognized setting.
	 * @return mixed Array of all settings by default. A single value if passed as first parameter.
	 */
	public static function get_setting( $key = 'all' ) {
		$saved = (array) get_option( 'featured-content' );

		$defaults = array(
			'tag-id'   => 0,
			'tag-name' => '',
			'show-all' => 0,
			'max-posts' => 20,
		);

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		if ( 'all' != $key ) {
			return isset( $options[ $key ] ) ? $options[ $key ] : false;
		}

		return $options;
	}

	/**
	 * Validate settings
	 *
	 * Make sure that all user supplied content is in an expected format before
	 * saving to the database. This function will also delete the transient set in
	 * Dynamic_News_Featured_Content::get_featured_content().
	 *
	 * @uses Dynamic_News_Featured_Content::delete_transient()
	 *
	 * @param array $input
	 * @return array $output
	 */
	public static function validate_settings( $input ) {
		$output = array();

		if ( empty( $input['tag-name'] ) ) {
			$output['tag-id'] = 0;
		} else {
			$term = get_term_by( 'name', $input['tag-name'], 'post_tag' );

			if ( $term ) {
				$output['tag-id'] = $term->term_id;
			} else {
				$new_tag = wp_create_tag( $input['tag-name'] );

				if ( ! is_wp_error( $new_tag ) && isset( $new_tag['term_id'] ) ) {
					$output['tag-id'] = $new_tag['term_id'];
				}
			}

			$output['tag-name'] = $input['tag-name'];
		}

		$output['show-all'] = isset( $input['show-all'] ) && $input['show-all'] ? 1 : 0;

		$output['max-posts'] = isset( $input['max-posts'] ) && $input['max-posts'] > 0 ? absint( $input['max-posts'] ) : 20;

		self::delete_transient();

		return $output;
	}
}

Dynamic_News_Featured_Content::setup();
