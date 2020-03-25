<?php
/*
 * Plugin Name: AIOS Filterable Gallery
 * Description: List of Listings
 * Version: 1.0.0
 * Author: Agent Image
 * Author URI: https://www.agentimage.com/
 * License: Proprietary
 */

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

if ( !defined( 'AIOS_FILTERABLE_URL' ) ) define( 'AIOS_FILTERABLE_URL', plugin_dir_url(__FILE__) );
if ( !defined( 'AIOS_FILTERABLE_DIR' ) ) define( 'AIOS_FILTERABLE_DIR', realpath( plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR ) );
if ( !defined( 'AIOS_FILTERABLE_FORMS_DIR' ) ) define( 'AIOS_FILTERABLE_FORMS_DIR', AIOS_FILTERABLE_DIR . '/includes/post-type/forms' . DIRECTORY_SEPARATOR );

if ( !defined( 'AIOS_FILTERABLE_URL_ASSETS' ) ) define( 'AIOS_FILTERABLE_URL_ASSETS', AIOS_FILTERABLE_URL . 'assets/' );
if ( !defined( 'AIOS_FILTERABLE_URL_ASSETS_IMAGES' ) ) define( 'AIOS_FILTERABLE_URL_ASSETS_IMAGES', AIOS_FILTERABLE_URL_ASSETS . 'images/' );
if ( !defined( 'AIOS_FILTERABLE_URL_ASSETS_CSS' ) ) define( 'AIOS_FILTERABLE_URL_ASSETS_CSS', AIOS_FILTERABLE_URL_ASSETS . 'css/' );
if ( !defined( 'AIOS_FILTERABLE_URL_ASSETS_JS' ) ) define( 'AIOS_FILTERABLE_URL_ASSETS_JS', AIOS_FILTERABLE_URL_ASSETS . 'js/' );


/** Require a helper file **/
require_once( 'helpers/file-loader.php' );

if ( !class_exists( 'aios_filterable_gallery' ) ) {

	class aios_filterable_gallery{

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct() {
			$this->add_actions();
			$this->autoloader();
		}

		/**
		 * Add Actions.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function add_actions() {
			register_activation_hook( __FILE__, array( $this, 'install' ) );
			register_deactivation_hook( __FILE__, array( $this, 'uninstall' ) );
		}

		/**
		 * Plugin Installation.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function install(){

            $plugins = [
                [
                    'name' => 'Contact Form 7',
                    'source' => 'contact-form-7/wp-contact-form-7.php',
                    'url' => 'https://wordpress.org/plugins/contact-form-7/'
                ],

                [
                    'name' => 'Advanced Custom Fields Pro',
                    'source' => 'advanced-custom-fields-pro/acf.php',
                    'url' => 'https://gitlab.forge99.com/Plugins/advanced-custom-fields-pro'
                ]
            ];
            $error_message = '';
            $counter = 1;
            foreach( $plugins as $plugin ) {
                if ( !is_plugin_active( $plugin['source'] ) ) {
                    $error_message .= $counter . '. <a href="' . $plugin['url'] . '" target="_blank">' . $plugin['name'] . '</a><br>';
                    $counter++;
                }
            }

            if ( $error_message ) {
                switch_theme( $oldtheme->stylesheet );

                $error_message = '
                    <div class="notice notice-error">
                        <p>
                            Please <strong>Download</strong> and <strong>Activate</strong> the following <strong>Plugin/s</strong>:
                        </p>
                        <p>' . $error_message . '</p>
                    </div>
                ';

                wp_die( $error_message );
            }else {
				$filterable_gallery_settings = get_option( 'filterable_gallery_settings' );
				if ( empty( $filterable_gallery_settings ) ) {
					$default = array(
						'permastructure' 			=> 'gallery',
					);
					update_option( 'filterable_gallery_settings', $default );

					/** This will check if default value change this will trigger flush_rewrite_rules() **/
					update_option( 'filterable_gallery_slug', 'gallery' );

					/** Refresh Permalink after Installation to make sure custom post type is registered **/
					flush_rewrite_rules();
				}
			}


		}

		/**
		 * Plugin Uninstallation.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function uninstall() { }

		public function autoloader() {
			require_once( 'aios-filterable-gallery-autoloader.php' );
		}

	}

	$aios_filterable_gallery = new aios_filterable_gallery();
	
}