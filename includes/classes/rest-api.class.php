<?php
/**
 * Sample URL:
 * /wp-json/aios-filterable-gallery/v1/s - This will get all the filterable_gallery
 * Accepted URL @param:
 * agent_id(int) - Post ID.
 * agent_filterable_gallery_sortby(selected-only / unselected-only / selected-first / unselected-first / date-created / alphanumeric ) -  This will get/except filterable_gallery under agent_id.
 * post_status(string / array) - use post status. Retrieves posts by Post Status, default value i'publish'.
 * posts_per_page(int) - number of post to show per page
 * paged(int) - Number of page. Show the posts that would normally show up just on page X.
 * order(ASC / DESC) - Designates the ascending or descending order of the 'orderby' parameter, default value DESC.
 * orderby(striing) - Sort retrieved posts by parameter.
 * slug - Get specific posts by slug
 * s - Search Query
 *
 * Sample URL to Get Agents Listings
 * /wp-json/aios-filterable-gallery/v1/s?agent_id=894&agent_filterable_gallery_sortby=selected-only - This will get all the filterable_gallery under Agent ID(894)
 * /wp-json/aios-filterable-gallery/v1/s?agent_id=894&agent_filterable_gallery_sortby=unselected-only - This will get all the filterable_gallery except Agent ID(894)
 */

if ( !class_exists( 'aios_filterable_gallery_rest_api' ) ) {

	class aios_filterable_gallery_rest_api {

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
			add_action( 'rest_api_init', array( $this, 'custom_rest_api' ), 10 );
		}

		/**
		 * Register Rest Route
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function custom_rest_api() {
			register_rest_route( 
				'aios-filterable-gallery/v1',
				'listing/', 
				array(
					'methods' 	=> WP_REST_Server::READABLE,
					'callback' 	=> array( $this, 'get_all_filterable_gallery' )
				)
			);

			register_rest_route( 
				'aios-filterable-gallery/v1',
				'listing/(?P<id>\d+)', 
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' )
				),
				array(
					'methods' 				=> WP_REST_Server::DELETABLE,
					'callback'            	=> array( $this, 'delete_item' ),
					'permission_callback' 	=> array( $this, 'delete_item_permissions_check' )
				)
			);
		}

		/**
		 * Check if a given request has access to get a specific item.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|boolean
		 */
		public function get_item_permissions_check( $request ) {
			return current_user_can( 'publish_pages' );
		}



		/**
		 * Check if a given request has access to delete a specific item.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|boolean
		 */
		public function delete_item_permissions_check( $request ) {
			return $this->get_item_permissions_check( $request );
		}

		/**
		 * Get a specific of items.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function get_item( $request ) {
			$posts 					= [];
			$post_id 				= $request->get_params( 'id' )['id'];

			$img 					= '';
			$author 				= empty( get_the_author($post_id) ) ? 'AgentImage' : get_the_author($post_id);
			$date_created 			= get_the_time( 'F d, Y', $post_id );
			$listing_details 		= get_post_meta( $post_id, '_listing_details', true );
			$listing_details 		= !empty( $listing_details ) ? $listing_details : array();

			$property_features 		= get_post_meta( $post_id, 'property_features', true );
			$property_features 		= !empty( $property_features ) ? $property_features : array();
			$property_features_name = [];

			/** Convert term id to name **/
			foreach ( $property_features as $value ) {
				$TermObject = get_term_by( 'id', $value, 'property-features' );
				$TermName = $TermObject->name;
				array_push( $property_features_name, $TermName );
			}

			$property_types 		= get_post_meta( $post_id, 'property_types', true );
			$property_types 		= !empty( $property_types ) ? $property_types : array();
			$property_types_name 	= [];

			/** Convert term id to name **/
			foreach ( $property_types as $value ) {
				$TermObject = get_term_by( 'id', $value, 'property-types' );
				$TermName = $TermObject->name;
				array_push( $property_types_name, $TermName );
			}

			$property_statuses 		= get_post_meta( $post_id, 'property_statuses', true );
			$property_statuses 		= !empty( $property_statuses ) ? $property_statuses : array();
			$property_statuses_name = [];

			/** Convert term id to name **/
			foreach ( $property_statuses as $value ) {
				$TermObject = get_term_by( 'id', $value, 'property-statuses' );
				$TermName = $TermObject->name;
				array_push( $property_statuses_name, $TermName );
			}

			$obj 					= new stdClass;
			$obj->id 				= $post_id;
			$obj->title 			= get_the_title( $post_id );
			$obj->author 			= $author;
			$obj->date_created 		= $date_created;
			$obj->url 				= get_the_permalink( $post_id );
			$obj->image_thumbnail 	= ( !empty( $listing_details['featured_image_id'] ) ? wp_get_attachment_image_url( $listing_details['featured_image_id'], 'thumbnail' ) : '' );
			$obj->image_medium 		= ( !empty( $listing_details['featured_image_id'] ) ? wp_get_attachment_image_url( $listing_details['featured_image_id'], 'medium' ) : '' );
			$obj->image_large 		= ( !empty( $listing_details['featured_image_id'] ) ? wp_get_attachment_image_url( $listing_details['featured_image_id'], 'large' ) : '' );
			$obj->image_full 		= ( !empty( $listing_details['featured_image_id'] ) ? wp_get_attachment_image_url( $listing_details['featured_image_id'], 'full' ) : '' );
			$obj->listing_details 	= $listing_details;
			$obj->property_features = $property_features_name;
			$obj->property_types 	= $property_types_name;
			$obj->property_statuses = $property_statuses_name;
			$posts[] 				= $obj;
			$posts 					= new WP_REST_Response($posts, 200);

			return $posts;
		}

		/**
		 * Delete one item from the collection.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function delete_item( WP_REST_Request $request ) {
			return new WP_REST_Response( Mapping::get( $request->get_param( 'id' ) )->delete() );
		}

		/**
		 * Call back for Register Rest Route
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public function get_all_filterable_gallery( $request ) {
			$posts = [];

			$param 		= $request->get_params();
			$agent_id 	= empty( $param['agent_id'] ) ? '' : $param['agent_id'];

			/** Accepted Value: selected-only, unselected-only, selected-first, unselected-first, date-created, alphanumeric ***/
			$agent_filterable_gallery_sortby 	= empty( $param['agent_filterable_gallery_sortby'] ) ? '' : $param['agent_filterable_gallery_sortby'];

			$post_status 	= empty( $param['post_status'] ) 	? 'publish' : $param['post_status'];
			$posts_per_page = empty( $param['posts_per_page'] ) ? 10 : $param['posts_per_page'];
			$paged 			= empty( $param['paged'] ) 			? 1 : $param['paged'];
			$order 			= empty( $param['order'] ) 			? 'DESC' : $param['order'];
			$orderby 		= empty( $param['orderby'] ) 		? 'date' : $param['orderby'];
			$slug 			= empty( $param['slug'] ) 			? '' : $param['slug'];
			$search 		= empty( $param['search'] ) 		? '' : $param['search'];

			$args = array(
				'post_type' 		=> 'aios-filterable-gallery',
				'post_status' 		=> $post_status,
				'posts_per_page' 	=> $posts_per_page,
				'paged' 			=> $paged,
				'order' 			=> $order,
				'orderby' 			=> $orderby,
				'name' 				=> $slug,
				's' 				=> $search
			);

			/** 
			 * The if statement will be use for aios-agents
			 * filterable_gallery_agents(arr) is a post_meta
			 * Get filterable_gallery under Agent ID
			 */
			if ( is_plugin_active( 'aios-agents/aios-agents.php' ) && !empty( $agent_id ) && !empty( $agent_filterable_gallery_sortby ) ) {
				/** This will show all filterable_gallery under Agent id **/
				$meta_query_selected = array(
					'meta_query' 		=> array(
						array(
							'key'		=> 'listing_agents',
							'value'		=> $agent_id,
							'compare'	=> 'LIKE'
						),
					)
				);
				$args_selected 	= array_merge( $args, $meta_query_selected );
				$query_selected = new WP_Query( $args_selected );

				/** This will show all filterable_gallery NOT under Agent id **/
				$meta_query_unselected = array(
					'meta_query' 		=> array(
						array(
							'key'		=> 'listing_agents',
							'value'		=> $agent_id,
							'compare'	=> 'NOT LIKE'
						),
					)
				);

				$args_unselected 	= array_merge( $args, $meta_query_unselected );
				$query_unselected 	= new WP_Query( $args_unselected );

				/** Create new empty WP_Query to merge both new and old lists of agents **/
				$query = new WP_Query();

				/** 
				 * Sorting - Merge both posts and post_count
				 * @param $query->posts - Contains array of content
				 * @param $query->post_count - Get the total number of posts that exist in the queries.
				 * @param $query->found_posts - Get the total number of posts that exist in the database.
				 * @param $query->max_num_pages - The total number of pages. Is the result of $query->found_posts / $posts_per_page
				 */
				if ( $agent_filterable_gallery_sortby == 'selected-only' ) {
					/** This will show all filterable_gallery under Agent id **/
					$query->posts 			= $query_selected->posts;
					$query->post_count 		= $query_selected->post_count;
					$query->found_posts 	= $query_selected->found_posts;
				} else if( $agent_filterable_gallery_sortby == 'unselected-only' ) {
					/** This will show all filterable_gallery NOT under Agent id **/
					$query->posts 			= $query_unselected->posts;
					$query->post_count 		= $query_unselected->post_count;
					$query->found_posts 	= $query_unselected->found_posts;
				} else if( $agent_filterable_gallery_sortby == 'selected-first' ) {
					/** We need to check if selected items is more than selected items **/
					$total_selected_count = ( $query_selected->post_count <= $posts_per_page ? $posts_per_page * $paged : 0 );
					if ( $query_selected->found_posts >= $total_selected_count + $query->post_count && $posts_per_page != -1 ) {
						$query->posts = $query_selected->posts;
						$query->post_count = $query_selected->post_count;
						$query->found_posts = $query_selected->found_posts;
					} else {
						$query->posts = array_merge( $query_selected->posts, $query_unselected->posts );
						$query->post_count = $query_selected->post_count + $query_unselected->post_count;
						$query->found_posts = $query_selected->found_posts + $query_unselected->found_posts;
					}
				} else if( $agent_filterable_gallery_sortby == 'unselected-first' ) {
					/** We need to check if unselected items is more than selected items **/
					$total_unselected_count = ( $query_unselected->post_count <= $posts_per_page ? $posts_per_page * $paged : 0 );
					if ( $query_unselected->found_posts >= $total_unselected_count + $query->post_count && $posts_per_page != -1 ) {
						$query->posts = $query_unselected->posts;
						$query->post_count = $query_unselected->post_count;
						$query->found_posts = $query_unselected->found_posts;
					} else {
						$query->posts = array_merge( $query_unselected->posts, $query_selected->posts );
						$query->post_count = $query_unselected->post_count + $query_selected->post_count;
						$query->found_posts = $query_unselected->found_posts + $query_selected->found_posts;
					}
				}

				/** Always round up after dividing **/
				$query->max_num_pages = ceil($query->found_posts / $posts_per_page);
			} else {
				/** Display if agent is not active and no search filter **/
				$query = new WP_Query( $args );
			}

			/** Set max number of pages and total num of posts **/
			$max_pages = $query->max_num_pages;
			$total = $query->found_posts;

			/** Prepare data for output **/
			$controller = new WP_REST_Posts_Controller( 'post' );

			while ( $query->have_posts() ) {
				$query->the_post();

				$post_id 				= get_the_ID();
				$img 					= '';
				$author 				= empty( get_the_author() ) ? 'AgentImage' : get_the_author();
				$date_created 			= get_the_time( 'F d, Y' );
				$listing_details 		= get_post_meta( $post_id, '_listing_details', true );
				$listing_details 		= !empty( $listing_details ) ? $listing_details : array();

				$property_features 		= get_post_meta( $post_id, 'property_features', true );
				$property_features 		= !empty( $property_features ) ? $property_features : array();
				$property_features_name = [];

				/** Convert term id to name **/
				foreach ( $property_features as $value ) {
					$TermObject = get_term_by( 'id', $value, 'property-features' );
					$TermName = $TermObject->name;
					array_push( $property_features_name, $TermName );
				}

				$property_types 		= get_post_meta( $post_id, 'property_types', true );
				$property_types 		= !empty( $property_types ) ? $property_types : array();
				$property_types_name 	= [];

				/** Convert term id to name **/
				foreach ( $property_types as $value ) {
					$TermObject = get_term_by( 'id', $value, 'property-types' );
					$TermName = $TermObject->name;
					array_push( $property_types_name, $TermName );
				}

				$property_statuses 		= get_post_meta( $post_id, 'property_statuses', true );
				$property_statuses 		= !empty( $property_statuses ) ? $property_statuses : array();
				$property_statuses_name = [];

				/** Convert term id to name **/
				foreach ( $property_statuses as $value ) {
					$TermObject = get_term_by( 'id', $value, 'property-statuses' );
					$TermName = $TermObject->name;
					array_push( $property_statuses_name, $TermName );
				}

				$obj 					= new stdClass;
				$obj->id 				= $post_id;
				$obj->title 			= get_the_title();
				$obj->author 			= $author;
				$obj->date_created 		= $date_created;
				$obj->url 				= get_the_permalink();
				$obj->image_thumbnail 	= ( !empty( $listing_details['featured_image_id'] ) ? wp_get_attachment_image_url( $listing_details['featured_image_id'], 'thumbnail' ) : '' );
				$obj->image_medium 		= ( !empty( $listing_details['featured_image_id'] ) ? wp_get_attachment_image_url( $listing_details['featured_image_id'], 'medium' ) : '' );
				$obj->image_large 		= ( !empty( $listing_details['featured_image_id'] ) ? wp_get_attachment_image_url( $listing_details['featured_image_id'], 'large' ) : '' );
				$obj->image_full 		= ( !empty( $listing_details['featured_image_id'] ) ? wp_get_attachment_image_url( $listing_details['featured_image_id'], 'full' ) : '' );
				$obj->listing_details 	= $listing_details;
				$obj->property_features = $property_features_name;
				$obj->property_types 	= $property_types_name;
				$obj->property_statuses = $property_statuses_name;

				/**
				 * The if statement will be use for aios-agents
				 * is_agent_listing - This will determine if the current listing is under Agent ID
				 */
				if ( is_plugin_active( 'aios-agents/aios-agents.php' ) && !empty( $agent_id ) ) {
					$agent_filterable_gallery 		= get_post_meta( $agent_id, 'agent_filterable_gallery', true );
					$agent_filterable_gallery 		= !empty( $agent_filterable_gallery ) ? $agent_filterable_gallery : array();
					$obj->is_agent_listing 	= in_array( $post_id, $agent_filterable_gallery ) ? true : false;
				}

				$posts[] = $obj;
			}

			/** Set headers and return response **/
			$posts = new WP_REST_Response($posts, 200);

			$posts->header( 'X-WP-Total', $total ); 
			$posts->header( 'X-WP-TotalPages', $max_pages );

			return $posts;
		}

	}

	$aios_filterable_gallery_rest_api = new aios_filterable_gallery_rest_api();
	
}