<?php
use \AIOS\Gallery\Classses\Options;

if ( !class_exists( 'aios_filterable_gallery_yoast' ) ) {

	class aios_filterable_gallery_yoast {

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
			/** Yoast Meta Description **/
			add_filter( 'wpseo_metadesc', [$this, 'listing_meta_description'], 100 );

			/** Open Graph **/
			$wpseo_social = get_option( 'wpseo_social' );
			if ( $wpseo_social['opengraph'] ) {
				add_filter( 'wpseo_opengraph_type', [$this, 'listing_opengraph_type'], 100 );
				add_filter( 'wpseo_add_opengraph_images', [$this, 'listing_opengraph_image'], 100 );
				add_filter( 'wpseo_opengraph_desc', [$this, 'listing_opengraph_desc'], 100 );
			}

			/** Twitter **/
			if ( $wpseo_social['twitter'] ) {
				if ( $wpseo_social['twitter_card_type'] == 'summary_large_image' ) {
					add_filter( 'wpseo_twitter_image', [$this, 'listing_twitter_image'], 100 );
				}
				add_filter( 'wpseo_twitter_description', [$this, 'listing_twitter_desc'], 100 );
			}

			/** Breadcrumbs */
			add_filter( 'wpseo_breadcrumb_links', [$this, 'yoast_breadcrumb_trail'] );
		}

		/**
		 * Add Meta Description if empty
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function listing_meta_description( $desc ) {
			$post_id = get_the_ID();

			if ( is_single() && get_post_type( $post_id ) == 'aios-filterable-gallery' ) {
				/** Get array of metabox value then extract **/
				$listing_details = get_post_meta( $post_id, '_listing_details' );
				$listing_details = !empty( $listing_details ) ? $listing_details[0] : array();

				/** Check if filterable_gallery details have value **/
				if( !empty( $listing_details ) ) extract( $listing_details );

				/** Description **/
				$description = ( isset( $property_description  ) ? strip_tags( $property_description )  : '' );

				$len 		= 155;
				$desc_len 	= strlen( $description );
				$desc_text 	= trim( substr( $description, 0, $len ) );
				$desc_text 	= preg_replace( '/\W\w+\s*(\W*)$/', '$1', $desc_text ); /** Remove Last Word/Single Letter **/
				$desc_ell	= $desc_len > $len ? ' ...' : '';
				$desc 		= $desc_text . $desc_ell;
			}

			return $desc;
		}

		/**
		 * Add Open Graph Image
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function listing_opengraph_type( $type ) {
			$post_id = get_the_ID();

			if ( is_single() && get_post_type( $post_id ) == 'aios-filterable-gallery' ) {
				$type = 'product';
			}

			return $type;
		}


		/**
		 * Add Open Graph Image
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function listing_opengraph_image( $object ) {
			$post_id = get_the_ID();

			if ( is_single() && get_post_type( $post_id ) == 'aios-filterable-gallery' ) {
				/** Get array of metabox value then extract **/
				$listing_details = get_post_meta( $post_id, '_listing_details' );
				$listing_details = !empty( $listing_details ) ? $listing_details[0] : array();

				/** Check if filterable_gallery details have value **/
				if( !empty( $listing_details ) ) extract( $listing_details );

				/** Featured Image **/
				$image = ( !empty( $featured_image_id ) ? wp_get_attachment_image_url( $featured_image_id, 'full' ) : '' );
				$object->add_image( $image );
			}
		}

		/**
		 * Add Open Graph Image
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function listing_opengraph_desc( $desc ) {
			$post_id = get_the_ID();
			
			if ( is_single() && get_post_type( $post_id ) == 'aios-filterable-gallery' ) {
				/** Get array of metabox value then extract **/
				$listing_details = get_post_meta( $post_id, '_listing_details' );
				$listing_details = !empty( $listing_details ) ? $listing_details[0] : array();

				/** Check if filterable_gallery details have value **/
				if( !empty( $listing_details ) ) extract( $listing_details );

				/** Description **/
				$description = ( isset( $property_description  ) ? strip_tags( $property_description )  : '' );

				$len 		= 290;
				$desc_len 	= strlen( $description );
				$desc_text 	= trim( substr( $description, 0, $len ) );
				$desc_text 	= preg_replace( '/\W\w+\s*(\W*)$/', '$1', $desc_text ); /** Remove Last Word/Single Letter **/
				$desc_ell	= $desc_len > $len ? ' ...' : '';
				$desc 		= $desc_text . $desc_ell;
			}

			return $desc;
		}

		/**
		 * Add Twitter Image
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function listing_twitter_image( $img ) {
			$post_id = get_the_ID();

			if ( is_single() && get_post_type( $post_id ) == 'aios-filterable-gallery' ) {
				/** Get array of metabox value then extract **/
				$listing_details = get_post_meta( $post_id, '_listing_details' );
				$listing_details = !empty( $listing_details ) ? $listing_details[0] : array();

				/** Check if filterable_gallery details have value **/
				if( !empty( $listing_details ) ) extract( $listing_details );

				/** Featured Image **/
				$img = ( !empty( $featured_image_id ) ? wp_get_attachment_image_url( $featured_image_id, 'full' ) : '' );
			}

			return $img;
		}

		/**
		 * Add Open Graph Image
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function listing_twitter_desc( $desc ) {
			$post_id = get_the_ID();

			if ( is_single() && get_post_type( $post_id ) == 'aios-filterable-gallery' ) {
				/** Get array of metabox value then extract **/
				$listing_details = get_post_meta( $post_id, '_listing_details' );
				$listing_details = !empty( $listing_details ) ? $listing_details[0] : array();

				/** Check if filterable_gallery details have value **/
				if( !empty( $listing_details ) ) extract( $listing_details );

				/** Description **/
				$description = ( isset( $property_description  ) ? strip_tags( $property_description )  : '' );

				$len 		= 270;
				$desc_len 	= strlen( $description );
				$desc_text 	= trim( substr( $description, 0, $len ) );
				$desc_text 	= preg_replace( '/\W\w+\s*(\W*)$/', '$1', $desc_text ); /** Remove Last Word/Single Letter **/
				$desc_ell	= $desc_len > $len ? ' ...' : '';
				$desc 		= $desc_text . $desc_ell;
			}

			return $desc;
		}

		/**
		 * Add custom breadcrumbs
		 */
		function yoast_breadcrumb_trail( $links ) {
			global $post;

			if ( is_single() && get_post_type( get_the_ID() ) == 'aios-filterable-gallery' ) {
				/** Get listing settings */
				$options = Options::Settings();
			
				/** First Item */
				$breadcrumb[] = array(
					'url' => get_bloginfo( 'home' ),
					'text' => 'Home',
				);
				array_splice( $links, 0, -1, $breadcrumb );
		
				/** Second Item */
				$breadcrumb[] = array(
					'url' => get_permalink( $options[ 'main_page' ] ),
					'text' => ucwords( $options[ 'permastructure' ] ),
				);
				array_splice( $links, 0, -1, $breadcrumb );
			}
		
			return $links;
		}

	}

	$aios_filterable_gallery_yoast = new aios_filterable_gallery_yoast();

}