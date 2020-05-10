<?php
use AIOS\Gallery\Classses\Options;

if ( !class_exists( 'aios_filterable_gallery_enqueue' ) ) {

	class aios_filterable_gallery_enqueue {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct() {
			$this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function add_actions() {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_ui' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_uiux' ) );
		}

        /**
		 * Enqueue scripts and styles
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_ui() {

			wp_enqueue_style( 'aios-filterable-style', AIOS_FILTERABLE_URL_ASSETS_CSS .'admin-style.css' );
			wp_enqueue_script( 'aios-filterable-script', AIOS_FILTERABLE_URL_ASSETS_JS .'admin-scripts.js' );

		}


		/**
		 * Enqueue scripts and styles
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function frontend_uiux() {
			wp_enqueue_style( 'aios-filterable-gallery-style', AIOS_FILTERABLE_URL_ASSETS_CSS .'aios-filterable-gallery.css' );
			wp_enqueue_script( 'aios-before-after', AIOS_FILTERABLE_URL_ASSETS_JS .'slider-before-after.js' );
			wp_enqueue_script( 'aios-ion-slider', AIOS_FILTERABLE_URL_ASSETS_JS .'ion.rangeSlider.min.js' );
			wp_enqueue_script( 'aios-filterable-gallery', AIOS_FILTERABLE_URL_ASSETS_JS .'aios-filterable-gallery.js' );
		}

	}

	$aios_filterable_gallery_enqueue = new aios_filterable_gallery_enqueue();
	
}