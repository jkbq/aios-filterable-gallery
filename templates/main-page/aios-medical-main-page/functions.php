<?php
/** Default Config */
use AIOS\Gallery\Classses\Options;

if ( !class_exists( 'aios_listings_main_page_template_default' ) ) {

	class aios_listings_main_page_template_default{
		
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
			 * $this->active_template_url = get_stylesheet_directory_uri() . '/listings-templates/main-page/default';
			 * $this->active_template_dir = get_stylesheet_directory() . '/listings-templates/main-page/default';
			 */
                $this->active_template_url = get_stylesheet_directory_uri() . '/filterable-gallery-templates/main-page/aios-medical-main-page';
                $this->active_template_dir = get_stylesheet_directory() . '/filterable-gallery-templates/main-page/aios-medical-main-page';

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

			if ( is_post_type_archive('gallery') ) {
				wp_enqueue_style( 'aios-ionSlider', $this->active_template_url . '/assets/css/ion.rangeSlider.min.css' );
				wp_enqueue_style( 'aios-fileterable-gallery-main-page-template-default-style', $this->active_template_url . '/assets/css/style.css' );

				wp_enqueue_script( 'customBASlideScript', $this->active_template_url . '/assets/js/slider-before-after.js' );
				wp_enqueue_script( 'aios-ionSlider-script', $this->active_template_url . '/assets/js/ion.rangeSlider.min.js' );
				wp_enqueue_script( 'aios-fileterable-gallery-main-page-template-default-script', $this->active_template_url . '/assets/js/scripts.js' );

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
            $listings_settings = Options::Settings();
			if( !empty( $listings_settings ) ) extract( $listings_settings );

			if ( is_post_type_archive( 'gallery') ) {
				$template = $this->active_template_dir . '/template.php';
			}

			return $template;
		}

	}

    $aios_listings_main_page_template_default = new aios_listings_main_page_template_default();

}