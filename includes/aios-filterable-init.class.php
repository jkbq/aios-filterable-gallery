<?php

if ( !class_exists( 'aios_filterable_gallery_init' ) ) {

	class aios_filterable_gallery_init {

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
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_uiux' ), 11 );
			add_action( 'admin_menu', array( $this,'render_sub_pages' ), 82 );
			add_action( 'wp_ajax_aios_filterable_gallery_generate_forms', array( $this, 'aios_filterable_gallery_generate_forms' ) );
			add_action( 'wp_ajax_nopriv_aios_filterable_gallery_generate_forms', array( $this, 'aios_filterable_gallery_generate_forms' ) );
		}

		/**
		 * Enqueue scripts and styles
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_uiux() {
			$admin_page_id = get_current_screen()->id;
			$admin_page_contains = 'aios-all-in-one_page_filterable_gallery-settings';
			
			if ( strpos($admin_page_id, $admin_page_contains) !== false ) {
				/** Enqueue Media Color Picker **/
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker-alpha', AIOS_INITIAL_SETUP_URL . 'includes/assets/js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ) );
				
				wp_enqueue_style( 'aios-filterable-gallery-style', AIOS_FILTERABLE_URL_ASSETS_CSS . 'admin-style.css' );
				wp_enqueue_script( 'aios-filterable-gallery-scripts', AIOS_FILTERABLE_URL_ASSETS_JS . 'admin-scripts.js' );
				wp_localize_script( 'aios-filterable-gallery-scripts', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
			}
		}

		/**
		 * Add sub menu page.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function render_sub_pages() {
			add_submenu_page(
				'aios-all-in-one',
				'Filterable Gallery',
				'Filterable Gallery',
				'manage_options', 
				'filterable_gallery-settings',
				array($this,'render_backend')
			);
		}
			public function render_backend() {
				require( 'render.php' );
			}

		/**
		 * Generate Default Forms.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function aios_filterable_gallery_generate_forms() {
			$aios_filterable_gallery_default_forms = new aios_filterable_gallery_default_forms();
			$aios_filterable_gallery_default_forms->generate();

			$notification = array();
			$notification[0] = 'Successfully Generated';
			echo json_encode( $notification );
			die();
		}

	}

	$aios_filterable_gallery_init = new aios_filterable_gallery_init();
	
}