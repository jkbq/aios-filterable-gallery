<?php
use AIOS\Gallery\Classses\Constant;

if ( !class_exists( 'aios_filterable_gallery_posts_columns' ) ) {

	class aios_filterable_gallery_posts_columns {

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
		 * @access protected
		 */
		protected function add_actions() {
			add_action( 'admin_head', array( $this, 'custom_style' ) );
			add_action( 'admin_head', array( $this, 'remove_yoast_seo_admin_filters' ), 20 );
			add_action( 'restrict_manage_posts', array( $this, 'property_status_filter' ), 10, 1 );
			add_filter( 'manage_aios-filterable-gallery_posts_columns', array( $this, 'set_custom_edit_aios_filterable_gallery_columns' ), 99 );
			add_action( 'manage_aios-filterable-gallery_posts_custom_column' , array( $this, 'custom_aios_filterable_gallery_column' ), 10, 2 );
			add_filter( 'manage_edit-aios-filterable-gallery_sortable_columns', array( $this, 'custom_edit_aios_filterable_gallery_column' ) );
			add_action( 'pre_get_posts', array( $this, 'column_position_orderby' ) );
			add_filter( 'list_table_primary_column', array( $this, 'aios_filterable_gallery_table_primary_column' ), 10, 2 );
		}

		/**
		 * Remove Yoast
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function remove_yoast_seo_admin_filters() {
			$admin_page_id = get_current_screen()->id;
			$admin_page_contains = 'edit-aios-filterable-gallery';

			if ( $admin_page_id == $admin_page_contains ) {
				global $wpseo_meta_columns;

				if ( $wpseo_meta_columns  ) {
					remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown' ) );
					remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown_readability' ) );
				}
			}
		}


		/**
		 * Add select filter
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function property_status_filter( $post_type ) {
			if ( 'aios-filterable-gallery' !== $post_type ) return;

			/** A list of taxonomy slugs to filter by **/
			$taxonomies = array( 'property-statuses' );

			foreach ( $taxonomies as $taxonomy_slug ) {

				/** Retrieve taxonomy data **/
				$taxonomy_obj = get_taxonomy( $taxonomy_slug );
				$taxonomy_name = $taxonomy_obj->labels->name;

				/** Retrieve taxonomy terms **/
				$terms = get_terms( $taxonomy_slug );

				/** Display filter HTML **/
				echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
				echo '<option value="">' . sprintf( $taxonomy_name ) . '</option>';
				foreach ( $terms as $term ) {
					printf(
						'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
						$term->slug,
						( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
						$term->name,
						$term->count
					);
				}
				echo '</select>';
			}
		}

		/**
		 * Add style for column.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function custom_style() {
			$admin_page_id = get_current_screen()->id;
			$admin_page_contains = 'edit-aios-filterable-gallery';

			if ( $admin_page_id == $admin_page_contains ) {
				echo '<style type="text/css">
					.manage-column.column-image { 
						width: 50px !important;
					}
				</style>';
			}
		}

		/**
		 * Add the custom columns to the aios-filterable-gallery post type.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function set_custom_edit_aios_filterable_gallery_columns($columns) {
			unset( $columns['tptn_total'] );
			unset( $columns['tptn_daily'] );
			unset( $columns['tptn_both'] );
			unset( $columns['title'] );
			unset( $columns['author'] );
			unset( $columns['date'] );
			unset( $columns['wpseo-linked'] );
			unset( $columns['wpseo-links'] );
			unset( $columns['wpseo-score'] );
			unset( $columns['wpseo-score-readability'] );
			unset( $columns['wpseo-title'] );
			unset( $columns['wpseo-metadesc'] );
			unset( $columns['wpseo-focuskw'] );

			$columns['image'] 		= '';
			$columns['address'] 	= 'Title - Address';
			$columns['city'] 		= 'City';
			$columns['state'] 		= 'State';
			$columns['price'] 		= 'Price';
			$columns['type'] 		= 'Type';
			$columns['status'] 		= 'Status';
			$columns['date'] 		= 'Date';

			return $columns;
		}

		/**
		 * Add the data to the custom columns for the aios-filterable-gallery post type.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function custom_aios_filterable_gallery_column( $column, $post_id ) {
			/** Lists of default values **/
			$constant_currency_arr = Constant::currency();

			/** Check Post Status **/
			$post_status = ( get_post_status( $post_id ) == 'draft' ? '  — <strong class="post-state">Draft</strong>' : '' );

			/** Get array of metabox value then extract **/
			$listing_details = get_post_meta( $post_id, '_listing_details' );
			$listing_details = !empty( $listing_details ) ? $listing_details[0] : array();

			/** Check if filterable_gallery details have value **/
			if( !empty( $listing_details ) ) extract( $listing_details );

			/** Default value to prevent undefined variables **/
			$title 					= get_the_title();
			$featured_image_uri 	= ( !empty( $featured_image_id ) ? wp_get_attachment_image_url( $featured_image_id ) : '' );
			$full_address 			= ( !empty( $full_address ) ? $full_address : '' );
			$address_unit_number 	= ( !empty( $address_unit_number ) ? $address_unit_number : '' );
			$address_street_number 	= ( !empty( $address_street_number ) ? $address_street_number : '' );
			$address_street_name 	= ( !empty( $address_street_name ) ? $address_street_name : '' );
			$address_city 			= ( !empty( $address_city ) ? $address_city . ' <a href="' . admin_url( 'edit.php?post_type=aios-filterable-gallery&city=' . $address_city ) . '">(View City)</a>' : '———' );
			$address_state 			= ( !empty( $address_state ) ? $address_state : '' );
			$address_zip_code 		= ( !empty( $address_zip_code ) ? $address_zip_code : '' );
			$unit_street 			= ( !empty( get_the_title() ) ? get_the_title() : 'Title/Address is Empty' );

			/** Property Types **/
			$property_types 		= get_the_terms( $post_id, 'property-types' );
			$property_types_text 	= '';
			if ( !empty( $property_types ) ) {
				foreach ( $property_types as $count => $property_type ) {
					$property_types_text .= ( $count != 0 ? ', ' : '' ) . $property_type->name;
				}
			}
			$property_types_text = ( !empty( $property_types_text ) ? $property_types_text : '———' );

			/** Property Status **/
			$property_statuses 		= get_the_terms( $post_id, 'property-statuses' );
			$property_statuses_text = '';
			if ( !empty( $property_statuses ) ) {
				foreach ( $property_statuses as $count => $property_status ) {
					$property_statuses_text .= ( $count != 0 ? ', ' : '' ) . $property_status->name;
				}
			}
			$property_statuses_text = ( !empty( $property_statuses_text ) ? $property_statuses_text : '———' );

			/** Property States **/
			$property_states 		= get_the_terms( $post_id, 'property-states' );
			if ( !empty( $property_states ) ) {
				$property_states_text = ( !empty( $property_states[0]->name ) ? $property_states[0]->name : '' );
				$property_states_slug = ( !empty( $property_states[0]->slug ) ? $property_states[0]->slug : '' );
			} else {
				$property_states_text = ( !empty( $address_state ) ? $address_state : '' );
				$property_states_slug = ( !empty( $address_slug ) ? $address_slug : '' );
			}
			$property_states_text = ( !empty( $property_states_text ) ? $property_states_text . ' <a href="' . admin_url( 'edit.php?post_type=aios-filterable-gallery&property-states=' . $property_states_slug ) . '">(View State)</a>' : '———' );

			/** Price **/
			$price_currency 		= ( !empty( $price_currency ) ? $constant_currency_arr[$price_currency] : '' );
			$sold_text 				= ( has_term( 'sold', 'property-statuses', $post_id ) ? 'Sold ' : '' );
			$listing_price 			= ( !empty( $price ) ? $sold_text . $price_currency . number_format( $price ) : '———' );

			switch ( $column ) {
				case 'image' :
					echo '<canvas width="50" height="50" style="background: url(' . $featured_image_uri . ') no-repeat center center; background-size: cover;"></canvas>';
					break;
				case 'address' :
					echo '<a href="' . get_edit_post_link( $post_id ) . '" class="row-title"><strong>' . $unit_street . '</strong></a>' . $post_status;
					break;
				case 'city' :
					echo $address_city;
					break;
				case 'state' :
					echo $property_states_text;
					break;
				case 'price' :
					echo $listing_price;
					break;
				case 'type' :
					echo $property_types_text;
					break;
				case 'status' :
					echo $property_statuses_text;
					break;
			}
		}

		/**
		 * Make column sortable.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function custom_edit_aios_filterable_gallery_column( $columns ) {
			$columns['address'] = 'address';
			$columns['city'] 	= 'city';
			$columns['state'] 	= 'state';
			$columns['price'] 	= 'price';
			return $columns;
		}

		/**
		 * Display Custom Column Position Sortable.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function column_position_orderby( $query ) {
			if( ! is_admin() ) return;

			$orderby = $query->get( 'orderby' );
			$city = ( isset( $_GET[ 'city' ] ) ? $_GET[ 'city' ] : '' );

			/** Order by Address, City, State - ASC/DESC **/
			if( 'address' == $orderby ) {
				$query->set('meta_key','full_address');
				$query->set('orderby','meta_value');
			} else if( 'city' == $orderby ) {
				$query->set('meta_key','address_city');
				$query->set('orderby','meta_value');
			} else if( 'state' == $orderby ) {
				$query->set('meta_key','address_state');
				$query->set('orderby','meta_value');
			} else if( 'price' == $orderby ) {
				$query->set('meta_key','price');
				$query->set('orderby','meta_value_num');
			}

			/** Lists of City Selected **/
			if ( $city != '' ) {
				$query->set('meta_key', 'address_city');
				$query->set('meta_value', $city);
			}
		}

		/**
		 * Move Row Action on Second Column.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function aios_filterable_gallery_table_primary_column( $default, $screen ) {
			if ( 'edit-aios-filterable-gallery' === $screen ) {
				$default = 'address';
			}
			return $default;
		}

	}

	$aios_filterable_gallery_posts_columns = new aios_filterable_gallery_posts_columns();

}