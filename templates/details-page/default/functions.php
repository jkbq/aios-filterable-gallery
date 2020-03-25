<?php
/**
 * Default Config
 *
 * @return void
 */
if ( !class_exists( 'aios_filterable_gallery_details_page_template_default' ) ) {

	class aios_filterable_gallery_details_page_template_default{
		
		/**
		 * Current file URL & DIR
		 *
		 * @access private
		 */
		private $active_template_url;
		private $active_template_dir;

		/**
		 * Constructor.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			/** 
			 * Custom - If files is under active theme
			 * $this->active_template_url = get_stylesheet_directory_uri() . '/filterable_gallery-templates/details-page/default';
			 * $this->active_template_dir = get_stylesheet_directory() . '/filterable_gallery-templates/details-page/default';
			 */
			$this->active_template_url = AIOS_FILTERABLE_URL . 'templates/details-page/default';
			$this->active_template_dir = AIOS_FILTERABLE_DIR . '/templates/details-page/default';

			$this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @access public
		 * @return void
		 */
		public function add_actions() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );
			add_filter( 'template_include', array( $this, 'custom_templates' ), 20 );
		}

		/**
		 * Enqueue Scripts
		 *
		 * @access public
		 * @return void
		 */
		public function enqueue_scripts() {
			if ( is_single() && get_post_type( get_the_ID() ) == 'aios-filterable-gallery' ) {
				wp_enqueue_style( 'aios-filterable-gallery-details-page-template-default-style', $this->active_template_url . '/assets/css/style.css' );
				wp_enqueue_script( 'aios-filterable-gallery-details-page-template-default-script', $this->active_template_url . '/assets/js/scripts.js' );
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

	}

    $aios_filterable_gallery_details_page_template_default = new aios_filterable_gallery_details_page_template_default();
    
}