<?php

if ( ! class_exists( 'filterable_gallery' ) ) {

	class filterable_gallery {

		public function __construct() {

		    add_filter( 'custom_menu_order', array( $this, 'submenu_order' ) );

            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_libs' ) );
            add_action( 'init', [$this, 'register_procedures'], 0 );
            add_action( 'init', [$this, 'custom_post_type'] );
            add_filter( 'aios_add_custom_metabox_after_content_gallery', [$this, 'adding_extra_field_after_content'] );
            add_action( 'save_post_gallery', [$this, 'custom_metaboxes_saved'] );



		}


        function submenu_order( $menu_order ) {
           global $submenu;

//             echo '<pre>'.print_r($submenu,true).'</pre>';

            // Build array of newly sorted items
            $arr = array();
//            $arr[] = $submenu['edit.php?post_type=cases'][5]; // Procedures
//            $arr[] = $submenu['edit.php?post_type=cases'][17]; // Custom Fields
//            $arr[] = $submenu['edit.php?post_type=cases'][15]; // Operations
//            $arr[] = $submenu['edit.php?post_type=cases'][10]; // Add New Procedues
//            $arr[] = $submenu['edit.php?post_type=cases'][16]; // Doctor
//
//
//            // Remove the originals
//            unset($submenu['edit.php?post_type=cases'][5]);
//            unset($submenu['edit.php?post_type=cases'][17]);
//            unset($submenu['edit.php?post_type=cases'][15]);
//            unset($submenu['edit.php?post_type=cases'][10]);
//            unset($submenu['edit.php?post_type=cases'][16]);


            // Add newly items to the list
            $submenu['edit.php?post_type=cases'] += $arr;

            return $menu_ord;
        }



		function enqueue_libs( $hook ){

			$screen = get_current_screen();
			if( $screen->post_type == 'gallery' ){

			    wp_enqueue_script( 'aios-filterable-gallery-details-page-template-default-script', AIOS_FILTERABLE_URL . 'assets/js/post-type.js' );

			}

		}


		  /**
         *
         * Register Taxoomy
         */
        public function register_procedures() {

            $labels = array(
                'name'                       => _x( 'Procedures', 'Taxonomy General Name', 'specialization' ),
                'singular_name'              => _x( 'Procedures', 'Taxonomy Singular Name', 'specialization' ),
                'menu_name'                  => __( 'Procedures', 'specialization' ),
                'all_items'                  => __( 'All Procedures', 'specialization' ),
                'parent_item'                => __( 'Parent Procedure', 'specialization' ),
                'parent_item_colon'          => __( 'Parent Procedure:', 'specialization' ),
                'new_item_name'              => __( 'New Procedure Name', 'specialization' ),
                'add_new_item'               => __( 'Add New Procedure', 'specialization' ),
                'edit_item'                  => __( 'Edit Procedure', 'specialization' ),
                'update_item'                => __( 'Update Procedure', 'specialization' ),
                'separate_items_with_commas' => __( 'Separate items with commas', 'specialization' ),
                'search_items'               => __( 'Search Procedures', 'specialization' ),
                'add_or_remove_items'        => __( 'Add or remove items', 'specialization' ),
                'choose_from_most_used'      => __( 'Choose from the most used items', 'specialization' ),
                'not_found'                  => __( 'Not Found', 'specialization' ),
            );
            $rewrite = array(
                'slug'                       => 'operations',
                'with_front'                 => true,
                'hierarchical'               => true,
            );
            $args = array(
                'labels'                     => $labels,
                'hierarchical'               => true,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => true,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
                'rewrite'                    => $rewrite,
            );
            register_taxonomy( 'procedure', array( 'cases' ), $args );
        }


		public function custom_post_type() {
			$labels = array(
				'name' 					=> 'Cases',
				'singular_name' 		=> 'cases',
				'add_new' 				=> 'Add New Cases',
				'add_new_item' 			=> 'Add New Cases',
				'edit_item' 			=> 'Edit Cases',
				'new_item' 				=> 'New Cases',
				'view_item' 			=> 'View Cases',
				'search_items' 			=> 'Search for a Cases',
				'not_found' 			=> 'Nothing Found',
				'not_found_in_trash' 	=> 'Nothing found in the Trash',
				'parent_item_colon' 	=> ''
			);

			$supports = array(
				'title',
			);

			$args = array(
				'labels' 				=> $labels,
				'supports' 				=> $supports,
				'public' 				=> true,
				'publicly_queryable' 	=> true,
				'show_ui' 				=> true,
				'query_var' 			=> true,
				'menu_icon' 			=> 'dashicons-format-gallery',
				'rewrite' 				=> array(
					'slug' 				=> 'gallery',
					'with_front' 		=> false
				),
				'capability_type' 		=> 'post',
				'hierarchical' 			=> false,
				'menu_position' 		=> 21,
				'has_archive' 			=> true /** editable content - archive-{cpt-name}.php **/
			);

			register_post_type( 'cases', $args );
		}

		/**
		 *
		 * Add extra fields
		 */
		public function adding_extra_field_after_content( $post_id ) {


		}


		/**
		 *
		 * Save post type: Gallery
		 */
		public function custom_metaboxes_saved( $post_id ) {
			/** Pointless if $_POST is empty (this happens on bulk edit) **/
			if ( empty( $_POST ) ) return $post_id;

			/** Verify taxonomies meta box nonce **/
			if ( !isset( $_POST['aios_gallery_meta_boxes_nonce'] ) || !wp_verify_nonce( $_POST['aios_gallery_meta_boxes_nonce'], 'aios-gallery-save-details' ) ) return;

			/** Verify quick edit nonce **/
			if ( isset( $_POST['_inline_edit'] ) && ! wp_verify_nonce( $_POST['_inline_edit'], 'inlineeditnonce' ) ) return $post_id;

			/** Don't save on autosave **/
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

			/** Check the user's permissions. **/
			if ( !current_user_can( 'edit_page', $post_id ) ) return;

			/** Check post status **/
			if ( get_post_status( $post_id ) == 'trash'  ) return;

			/** Unhook this function to prevent infinite looping **/
			remove_action( 'save_post_gallery', 'custom_metaboxes_saved' );

		}


	}

	$filterable_gallery = new filterable_gallery();

}