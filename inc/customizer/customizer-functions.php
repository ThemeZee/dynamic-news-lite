<?php
/**
 * Theme Customizer Functions
 *
 */

/*========================== CUSTOMIZER CONTROLS FUNCTIONS ==========================*/

// Add simple heading option to the theme customizer
if ( class_exists( 'WP_Customize_Control' ) ) :

    class Dynamic_News_Customize_Header_Control extends WP_Customize_Control {

        public function render_content() {  ?>
			
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			</label>
			
<?php
        }
    }
	
	class Dynamic_News_Customize_Description_Control extends WP_Customize_Control {

        public function render_content() {  ?>
			
			<span class="description"><?php echo esc_html( $this->label ); ?></span>
			
<?php
        }
    }
	
	class Dynamic_News_Customize_Text_Control extends WP_Customize_Control {

        public function render_content() {  ?>
			
			<span class="textfield"><?php echo esc_html( $this->label ); ?></span>
			
<?php
        }
    }
	
	class Dynamic_News_Customize_Button_Control extends WP_Customize_Control {

        public function render_content() {  ?>
			
			<p>
				<a href="http://themezee.com/themes/dynamicnews/#PROVersion-1" target="_blank" class="button button-secondary">
					<?php echo esc_html( $this->label ); ?>
				</a>
			</p>
			
<?php
        }
    }
	
	class Dynamic_News_Customize_Font_Control extends WP_Customize_Control {
	
		private $fonts = false;
		
		public function __construct($manager, $id, $args = array(), $options = array()) {
		
			$this->fonts = array(
				'Arial' => 'Arial',
				'Alef' => 'Alef',
				'Bitter' => 'Bitter',
				'Carme' => 'Carme',
				'Droid Sans' => 'Droid Sans',
				'Francois One' => 'Francois One',
				'Josefin Slab' => 'Josefin Slab',
				'Lobster' => 'Lobster',
				'Luckiest Guy' => 'Luckiest Guy',
				'Jockey One' => 'Jockey One',
				'Maven Pro' => 'Maven Pro',
				'Modern Antiqua' => 'Modern Antiqua',
				'Nobile' => 'Nobile',
				'Oswald' => 'Oswald',
				'Permanent Marker' => 'Permanent Marker',
				'Roboto' => 'Roboto',
				'Raleway' => 'Raleway',
				'Share' => 'Share',
				'Tahoma' => 'Tahoma',
				'Ubuntu' => 'Ubuntu',
				'Verdana' => 'Verdana');
			parent::__construct( $manager, $id, $args );
			
		}
		
		public function render_content() {
		
			if( !empty($this->fonts) ) :
            ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<div class="customize-font-select-control">
						<select <?php $this->link(); ?>>
							<?php
								foreach ( $this->fonts as $k => $v )
								{
									printf('<option value="%s" %s>%s</option>', $k, selected($this->value(), $k, false), $v);
								}
							?>
						</select>
					</div>
				</label>
                
            <?php
			endif;
		}
		
	}
	
endif;


/*========================== CUSTOMIZER SANITIZE FUNCTIONS ==========================*/

// Sanitize checkboxes
function dynamicnews_sanitize_checkbox( $value ) {

	if ( $value == 1) :
        return 1;
	else:
		return '';
	endif;
}


// Sanitize the layout width value.
function dynamicnews_sanitize_layout( $value ) {

	if ( ! in_array( $value, array( 'boxed', 'wide' ) ) ) :
        $value = 'boxed';
	endif;

    return $value;
}


// Sanitize the layout sidebar value.
function dynamicnews_sanitize_sidebar( $value ) {

	if ( ! in_array( $value, array( 'left-sidebar', 'right-sidebar', 'fullwidth' ) ) ) :
        $value = 'right-sidebar';
	endif;

    return $value;
}


// Sanitize the post length value.
function dynamicnews_sanitize_post_length( $value ) {

	if ( ! in_array( $value, array( 'index', 'excerpt' ) ) ) :
        $value = 'index';
	endif;

    return $value;
}


// Sanitize the slider animation value.
function dynamicnews_sanitize_slider_animation( $value ) {

	if ( ! in_array( $value, array( 'horizontal', 'fade' ) ) ) :
        $value = 'horizontal';
	endif;

    return $value;
}


?>