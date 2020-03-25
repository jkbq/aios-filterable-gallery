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
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_uiux' ) );
		}

		/**
		 * Enqueue scripts and styles
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function frontend_uiux() {
			$filterable_gallery_settings = Options::Settings();
			if( !empty( $filterable_gallery_settings ) ) extract( $filterable_gallery_settings );

			if ( empty( $google_map_key ) || $disable_google_map == 1 ) {
				/** Check if we need to exclude google maps on homepage **/
				if ( $google_map_exclude_homepage == 1 ) {
					if ( !is_home() ) {
						wp_enqueue_style( 'aios-maptiler-leaflet', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.css' );
						wp_enqueue_style( 'aios-maptiler-mapbox', 'https://cdn.maptiler.com/mapbox-gl-js/v0.53.0/mapbox-gl.css' );

						wp_enqueue_script( 'aios-maptiler-leaflet', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.js' );
						wp_enqueue_script( 'aios-maptiler-mapbox', 'https://cdn.maptiler.com/mapbox-gl-js/v0.53.0/mapbox-gl.js' );
						wp_enqueue_script( 'aios-maptiler-leaflet-mapbox', 'https://cdn.maptiler.com/mapbox-gl-leaflet/latest/leaflet-mapbox-gl.js' );
					}
				} else {
					wp_enqueue_style( 'aios-maptiler-leaflet', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.css' );
					wp_enqueue_style( 'aios-maptiler-mapbox', 'https://cdn.maptiler.com/mapbox-gl-js/v0.53.0/mapbox-gl.css' );

					wp_enqueue_script( 'aios-maptiler-leaflet', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.js' );
					wp_enqueue_script( 'aios-maptiler-mapbox', 'https://cdn.maptiler.com/mapbox-gl-js/v0.53.0/mapbox-gl.js' );
					wp_enqueue_script( 'aios-maptiler-leaflet-mapbox', 'https://cdn.maptiler.com/mapbox-gl-leaflet/latest/leaflet-mapbox-gl.js' );
				}
			} else {
				/** Check if we need to exclude google maps on homepage **/
				if ( $google_map_exclude_homepage == 1 ) {
					if ( !is_home() ) {
						wp_enqueue_script( 'aios-google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.31&key=' . $google_map_key, array(), null, true );
						wp_enqueue_script( 'aios-google-maps-markerwithlabel', AIOS_FILTERABLE_URL_ASSETS_JS . 'gmaps-markerwithlabel.js', array(), null, true );
						wp_enqueue_script( 'aios-google-maps-markerclusterer', AIOS_FILTERABLE_URL_ASSETS_JS . 'markerclusterer.min.js', array(), null, true );
						wp_enqueue_script( 'aios-google-maps-infobubble', AIOS_FILTERABLE_URL_ASSETS_JS . 'infobubble.min.js', array(), null, true );
					}
				} else {
					wp_enqueue_script( 'aios-google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.31&key=' . $google_map_key, array(), null, true );
					wp_enqueue_script( 'aios-google-maps-markerwithlabel', AIOS_FILTERABLE_URL_ASSETS_JS . 'gmaps-markerwithlabel.js', array(), null, true );
					wp_enqueue_script( 'aios-google-maps-markerclusterer', AIOS_FILTERABLE_URL_ASSETS_JS . 'markerclusterer.min.js', array(), null, true );
					wp_enqueue_script( 'aios-google-maps-infobubble', AIOS_FILTERABLE_URL_ASSETS_JS . 'infobubble.min.js', array(), null, true );
				}
			}
		}

	}

	$aios_filterable_gallery_enqueue = new aios_filterable_gallery_enqueue();
	
}