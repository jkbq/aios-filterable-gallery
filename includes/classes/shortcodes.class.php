<?php
use AIOS\Gallery\Classses\Constant;

if ( !class_exists( 'aios_filterable_gallery_shortcodes' ) ) {

	class aios_filterable_gallery_shortcodes {

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			$this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		protected function add_actions() {
			if ( !shortcode_exists('aios_filterable_gallery') ) add_shortcode( 'aios_filterable_gallery', array( $this, 'get_aios_filterable_gallery' ) );
		}

		/**
		 * Display All Listings
		 *
		 * @since 3.1.8
		 * @access public
		 * @return string
		 */
		public function get_aios_filterable_gallery( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'post_status' 	=> 'publish',
				'post__in' 		=> '',
				'showposts' 	=> 10,
				'order' 		=> 'DESC',
				'orderby' 		=> 'date',
				'slug' 			=> '',
				'search' 		=> '',
				'image_size' 	=> 'large',
				/** List of Search **/
			), $atts ) );

			/** Lists of default values **/
			$constant_currency_arr = Constant::currency();

			$query_args = array(
				'post_type' 	=> 'aios-filterable-gallery',
				'post__in' 		=> $post__in,
				'post_status' 	=> $post_status,
				'showposts' 	=> $showposts,
				'order' 		=> $order,
				'orderby' 		=> $orderby,
				'name' 			=> $slug,
				's' 			=> $search
			);

			$query_filterable_gallery 	= new WP_Query( $query_args );
			$html_content 		= $content;
			$content 			= '';
			$listing_shortcodes = array(
				'[title]',
				'[permalink]',
				'[featured_image]',
				'[address_unit_number]',
				'[address_street_number]',
				'[address_street_name]',
				'[address_city]',
				'[address_state]',
				'[address_zip_code]',
				'[full_address]',
				'[details_mls_number]',
				'[details_bedrooms]',
				'[details_bathrooms]',
				'[details_garage_spaces]',
				'[details_architectural_styles]',
				'[details_year_built]',
				'[details_condition_status]',
				'[details_lot_area]',
				'[details_flooring_size]',
				'[details_appx_living_area]',
				'[details_lot_area_units]',
				'[details_flooring_size_units]',
				'[details_appx_living_area_units]',
				'[property_description]',
				'[price_currency]',
				'[price]',
				'[property_types_text]',
				'[property_statuses_text]',
				'[property_states_text]'
			);


			if ( $query_filterable_gallery->have_posts() ) {
				while ( $query_filterable_gallery->have_posts() ) {
					$query_filterable_gallery->the_post();

					/** Variables **/
					$post_id = get_the_ID();

					/** Get array of metabox value then extract **/
					$listing_details = get_post_meta( $post_id, '_listing_details' );
					$listing_details = !empty( $listing_details ) ? $listing_details[0] : array();

					/** Check if filterable_gallery details have value **/
					if( !empty( $listing_details ) ) extract( $listing_details );

					/** Builtin Variables **/
					$title 							= get_the_title();
					$permalink 						= get_the_permalink();

					/** Featured Image **/
					$featured_image_uri     		= ( !empty( $featured_image_id ) ? wp_get_attachment_image_url( $featured_image_id, $image_size ) : '' );

					/** Address **/
					$address_unit_number 			= ( isset( $address_unit_number )	? $address_unit_number . ' ' : '' );
					$address_street_number 			= ( isset( $address_street_number )	? $address_street_number . ' ' : '' );
					$address_street_name 			= ( isset( $address_street_name )	? $address_street_name : '' );
					$address_city 					= ( isset( $address_city )			? $address_city : '' );
					$address_state 					= ( isset( $address_state )			? ', ' . $address_state : '' );
					$address_zip_code 				= ( isset( $address_zip_code )		? ' ' . $address_zip_code : '' );
					$full_address 					= $address_unit_number . ' ' . $address_street_number . ' ' . $address_street_name . ' ' . $address_city . ' ' . $address_state . ' ' . $address_zip_code;

					/** Details **/
					$details_mls_number 			= ( isset( $details_mls_number ) ? $details_mls_number : '' );
					$details_bedrooms 				= ( isset( $details_bedrooms ) ? $details_bedrooms : '' );
					$details_bathrooms 				= ( isset( $details_bathrooms ) ? $details_bathrooms : '' );
					$details_garage_spaces 			= ( isset( $details_garage_spaces ) ? $details_garage_spaces : '' );
					$details_architectural_styles 	= ( isset( $details_architectural_styles ) ? $details_architectural_styles : '' );
					$details_year_built 			= ( isset( $details_year_built ) ? $details_year_built : '' );
					$details_condition_status 		= ( isset( $details_condition_status ) ? $details_condition_status : '' );
					$details_lot_area 				= ( isset( $details_lot_area  ) ? $details_lot_area  : '' );
					$details_flooring_size 			= ( isset( $details_flooring_size  ) ? $details_flooring_size  : '' );
					$details_appx_living_area 		= ( isset( $details_appx_living_area  ) ? $details_appx_living_area  : '' );
					$details_lot_area_units 		= ( isset( $details_lot_area_units  ) ? $details_lot_area_units  : '' );
					$details_flooring_size_units 	= ( isset( $details_flooring_size_units  ) ? $details_flooring_size_units  : '' );
					$details_appx_living_area_units = ( isset( $details_appx_living_area_units  ) ? $details_appx_living_area_units  : '' );
					$property_description 			= ( isset( $property_description  ) ? $property_description  : '' );

					/** Price **/
					$price_currency 				= ( isset( $price_currency ) ? $constant_currency_arr[$price_currency] : '' );
					$list_price 					= ( isset( $list_price ) ? number_format($list_price) : '' );
					$sold_price 					= ( isset( $sold_price ) ? number_format($sold_price) : '' );
					$display_sold 					= ( isset( $display_sold ) ? $display_sold : '' );
					$price 							= ( !empty( $display_sold ) && !empty( $sold_price ) ? $sold_price : $list_price );

					/** Property Types **/
					$property_types = get_the_terms( $post_id, 'property-types' );
					$property_types_text 	= '';
					if ( !empty( $property_types ) ) {
						foreach ( $property_types as $count => $property_type ) {
							$property_types_text .= ( $count != 0 ? ', ' : '' ) . $property_type->name;
						}
					}
					$property_types_text = ( !empty( $property_types_text ) ? $property_types_text : '' );

					/** Property Status **/
					$property_statuses = get_the_terms( $post_id, 'property-statuses' );
					$property_statuses_text = '';
					if ( !empty( $property_statuses ) ) {
						foreach ( $property_statuses as $count => $property_status ) {
							$property_statuses_text .= ( $count != 0 ? ', ' : '' ) . $property_status->name;
						}
					}
					$property_statuses_text = ( !empty( $property_statuses_text ) ? $property_statuses_text : '' );

					/** Property States **/
					$property_states = get_the_terms( $post_id, 'property-states' );
					if ( !empty( $property_states ) ) {
						$property_states_text = ( !empty( $property_states[0]->name ) ? $property_states[0]->name : '' );
						$property_states_slug = ( !empty( $property_states[0]->slug ) ? $property_states[0]->slug : '' );
					} else {
						$property_states_text = ( !empty( $address_state ) ? $address_state : '' );
						$property_states_slug = ( !empty( $address_slug ) ? $address_slug : '' );
					}

					$listing_fields = array(
						$title,
						$permalink,
						$featured_image,
						$address_unit_number,
						$address_street_number,
						$address_street_name,
						$address_city,
						$address_state,
						$address_zip_code,
						$full_address,
						$details_mls_number,
						$details_bedrooms,
						$details_bathrooms,
						$details_garage_spaces,
						$details_architectural_styles,
						$details_year_built,
						$details_condition_status,
						$details_lot_area,
						$details_flooring_size,
						$details_appx_living_area,
						$details_lot_area_units,
						$details_flooring_size_units,
						$details_appx_living_area_units,
						$property_description,
						$price_currency,
						$price,
						$property_types_text,
						$property_statuses_text,
						$property_states_text
					);

					$content .= str_replace( $listing_shortcodes, $listing_fields, $html_content );
				}
			} else {
				$content = ' No Listings to Display ';
			}

			return $content;
		}
		
	}

	$aios_filterable_gallery_shortcodes = new aios_filterable_gallery_shortcodes();
	
}
