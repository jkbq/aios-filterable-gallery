<?php


if ( !class_exists( 'aios_photos_stagings_api' ) ) {

	class aios_photos_stagings_api {

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
				'aios-gallery',
				'data/',
				array(
					'methods' 	=> WP_REST_Server::ALLMETHODS,
					'callback' 	=> array( $this, 'get_all_stagings' )
				)
			);


		}


		public function get_all_stagings( $request ) {
			$posts = [];

			$param 		= $request->get_params();



			$posts_per_page = empty( $param['posts_per_page'] ) ? 10 : $param['posts_per_page'];
			$paged 			= empty( $param['paged'] ) 			? 1 : $param['paged'];
			$order 			= empty( $param['order'] ) 			? 'DESC' : $param['order'];
			$orderby 		= empty( $param['orderby'] ) 		? 'date' : $param['orderby'];
			$slug 			= empty( $param['slug'] ) 			? '' : $param['slug'];
			$search 		= empty( $param['search'] ) 		? '' : $param['search'];

            $args = array(
					'post_type'			=> 'cases',
					'posts_per_page' 	=> $posts_per_page,
					'paged' 			=> $paged,
					'order' 			=> $order,
					'orderby' 			=> $orderby,
					'name' 				=> $slug,
					's' 				=> $search,
				);

			$query = new WP_Query( $args );

			/** Set max number of pages and total num of posts **/
			$max_pages = $query->max_num_pages;
			$total = $query->found_posts;

			/** Prepare data for output **/
			$controller = new WP_REST_Posts_Controller( 'post' );


			while ( $query->have_posts() ) {
				$query->the_post();

				$post_id 				= get_the_ID();

				$author 				= empty( get_the_author() ) ? 'AgentImage' : get_the_author();
				$date_created 			= get_the_time( 'F d, Y' );

				$design_files 		= isset( $design_files ) ? $design_files : '';


				$obj 					= new stdClass;
				$obj->id 				= $post_id;
				$obj->title 			= get_the_title();
				$obj->author 			= $author;
				$obj->date_created 		= $date_created;
				$obj->post_excerpt		= get_the_excerpt();
				$obj->url 				= get_the_permalink();
				$obj->case_number		= get_field('case_number', $post_id);
				$obj->gender		    = get_field( 'gender', $post_id);
				$obj->age		        = get_field( 'age', $post_id);
                $obj->ethnicity		    = get_field( 'ethnicity', $post_id);


                $images = array();

				$procedures = wp_get_post_terms( $post_id, 'procedure',  array( 'orderby' => 'parent', 'order' => 'ASC' ) );

                $args = array(
                    'numberposts' => 10,
                    'post_type'   => 'acf-field-group'
                );

                $group_fields = get_posts( $args );

                $procedure_names          = array();

                $case_details_arrs = array();


                foreach ( $procedures as $key => $procedure ) {
                    if ($key != 0) {
                        $procedure_names[] = $procedure->name;
                    }

                    foreach ($group_fields as $group_field) {

                        if ($procedure->name == $group_field->post_title) {
                                $fieldGroup = acf_get_field_group($group_field->ID);
                                $fields = acf_get_fields_by_id($group_field->ID);


                                 foreach ($fields as $field) {
                                    $field_label = $field['label'];
                                    $field_name = $field['name'];

                                    if ($field['label'] == 'Add Photos'){
                                        $imgGallery = get_field($field_name, $post_id);
                                        $imgBefore  =  $imgGallery[0]['before']['ID'];
                                        $imgAfter   = $imgGallery[0]['after']['ID'];

                                        $images[]  = array(
                                            'before'=> wp_get_attachment_url($imgBefore),
                                            'after' => wp_get_attachment_url($imgAfter)
                                        );

                                    }
                                     if ( $field['label'] == 'Case Details') {
                                         $case_details = get_field($field['name'], $post_id);

                                        $sub_fields = $field['sub_fields'];
                                        $case_details_arrs[] = array(
                                            'test'
                                        );
                                        foreach ( $sub_fields as $sub_field) {

                                            $case_details_arrs[]  = array(
                                                $sub_field['name']=> get_field($field['name'], $post_id),
                                            );
                                        }

                                     }



                                 }
                        }
                    }


                }




                $obj->term_names = $procedure_names;
                $obj->images       = $images;
                $obj->case_details          = $case_details_arrs;


				$obj->max_pages = $max_pages;

				$posts[] = $obj;
			}

			/** Set headers and return response **/
			$posts = new WP_REST_Response($posts, 200);

			$posts->header( 'X-WP-Total', $total );
			$posts->header( 'X-WP-TotalPages', $max_pages );

			return $posts;
		}

	}

}
$aios_photos_stagings_api = new aios_photos_stagings_api();