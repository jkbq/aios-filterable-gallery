<?php
/**
 * Common methods to create input, select, and textarea
 *
 * @return void
 */
use AIOS\Gallery\Config;
if ( !class_exists( 'aios_filterable_gallery_run_template' ) ) {

	class aios_filterable_gallery_run_template {

		public function __construct() {
			/** array - pages and archive */
			$arhive_pages = array(
				'main-page',
				'details-page',

			);

			foreach( $arhive_pages as $arhive_page ) {

				$page 		= Config::get_template_location( $arhive_page );
				$template 	= get_option( 'gallery-' . $arhive_page, 'default-core' );

                if ( isset( $page[ $template ][ 'is_active' ] ) && $page[ $template ][ 'is_active' ] == 'active-template' ) {
                    if( file_exists( $page[ $template ][ 'template_functions' ] ) ) {
                        require_once( $page[ $template ][ 'template_functions' ] );

                    }
                }
			}

		}

	}

	$aios_filterable_gallery_run_template = new aios_filterable_gallery_run_template();
	
}