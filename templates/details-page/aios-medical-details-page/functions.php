<?php
/**
 * Default Config
 *
 * @return void
 */
if ( !class_exists( 'aios_listings_details_page_template_default' ) ) {

	class aios_listings_details_page_template_default{
		
		/**
		 * Current file URL & DIR
		 *
		 * @access private
		 */
		private $active_template_url;
		private $active_template_dir;
        private $template_name;

		/**
		 * Constructor.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
            /** 
            * Custom - If files is under active theme
            * $this->active_template_url = get_stylesheet_directory_uri() . '/listings-templates/details-page/default';
            * $this->active_template_dir = get_stylesheet_directory() . '/listings-templates/details-page/default';
            */
            
            $this->template_name = basename( dirname( __FILE__ ) );
            
            $this->active_template_url = get_stylesheet_directory_uri() . '/filterable-gallery-templates/details-page/' . $this->template_name;
            $this->active_template_dir = get_stylesheet_directory() . '/filterable-gallery-templates/details-page/' . $this->template_name;

            $this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @access public
		 * @return void
		 */
		public function add_actions() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
			add_filter( 'template_include', array( $this, 'custom_templates' ), 20 );
            
            add_action( 'edit_form_after_title', array( $this, 'acf_filterable_gallery_post_id' ) );
            add_filter( 'acf/validate_value/name=case_number', array( $this, 'acf_filterable_gallery_case_number_validate_value' ), 10, 4 );
		}

		/**
		 * Enqueue Scripts
		 *
		 * @access public
		 * @return void
		 */
		public function enqueue_scripts() {
			if ( is_single() && get_post_type( get_the_ID() ) == 'gallery' ) {
				wp_enqueue_style( 'aios-filterable-gallery-' . $this->template_name . '-style', $this->active_template_url . '/assets/css/style.css' );
				wp_enqueue_script( 'aios-filterable-gallery-' . $this->template_name . '-script', $this->active_template_url . '/assets/js/scripts.js' );
			}
		}

		/**
		 * Custom Template
		 *
		 * @access public
		 * @param $template - file
		 * @return void
		 */
		public function custom_templates( $template ) {
			if ( is_single() && get_post_type( get_the_ID() ) == 'gallery' ) {
				remove_filter( 'the_content', 'wpautop' );
				$template = $this->active_template_dir . '/template.php';
			}

			return $template;
		}
        
        
        function acf_filterable_gallery_post_id() {
            global $post;
            
            if( $post && isset( $post->ID ) ) {
                echo '
                    <input type="hidden" name="acf[post_id]" value="' . $post->ID . '" />
                ';
            }
        }
        
        public function acf_filterable_gallery_case_number_validate_value( $valid, $value, $field, $input_name ) {
            // Return if case number value already exist
            $post_id = $_POST[ 'acf' ][ 'post_id' ];
            
            $args = [
                'posts_per_page' => -1,
                'post_type' => 'gallery',
                'exclude' => [ $post_id ],
                'meta_query' => [
                    [
                        'key' => 'case_number',
                        'value' => $value,
                        'compare' => '='
                    ],
                ]
            ];
            
            $posts = get_posts( $args );
            
            if ( $posts ) {
                return __( 'case number  <strong>' . $value . '</strong> already exists' );
            }
            
            return $valid;
        }

	}

    $aios_listings_details_page_template_default = new aios_listings_details_page_template_default();
    
}
