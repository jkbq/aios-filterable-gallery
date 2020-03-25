<?php

if ( ! class_exists( 'doctors' ) ) {

	class doctors {

		public function __construct() {
			add_action( 'init', [$this, 'custom_post_type'] );
			add_filter( 'aios_add_custom_metabox_after_content_doctor', [$this, 'adding_extra_field_after_content'] );

			add_action( 'save_post_doctor', [$this, 'custom_metaboxes_saved'] );
		}


		public function custom_post_type() {
			$labels = array(
				'name' 					=> 'Doctors',
				'singular_name' 		=> 'Doctors',
				'add_new' 				=> 'Add New Doctors',
				'add_new_item' 			=> 'Add New Doctors',
				'edit_item' 			=> 'Edit Doctors',
				'new_item' 				=> 'New Doctors',
				'view_item' 			=> 'View Doctors',
				'search_items' 			=> 'Search Doctors',
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
				'menu_icon' 			=> 'dashicons-buddicons-buddypress-logo',
				'rewrite' 				=> array(
					'slug' 				=> 'doctor',
					'with_front' 		=> false
				),
				'capability_type' 		=> 'post',
				'hierarchical' 			=> false,
				'menu_position' 		=> 21,
				'has_archive' 			=> true /** editable content - archive-{cpt-name}.php **/
			);

			register_post_type( 'doctor', $args );
		}

		/**
		 *
		 * Add extra fields
		 */
		public function adding_extra_field_after_content( $post_id ) {


		}


		/**
		 *
		 * Save post type: Doctors
		 */
		public function custom_metaboxes_saved( $post_id ) {
			/** Pointless if $_POST is empty (this happens on bulk edit) **/
			if ( empty( $_POST ) ) return $post_id;

			/** Verify taxonomies meta box nonce **/
			if ( !isset( $_POST['aios_doctor_meta_boxes_nonce'] ) || !wp_verify_nonce( $_POST['aios_doctor_meta_boxes_nonce'], 'aios-doctor-save-details' ) ) return;

			/** Verify quick edit nonce **/
			if ( isset( $_POST['_inline_edit'] ) && ! wp_verify_nonce( $_POST['_inline_edit'], 'inlineeditnonce' ) ) return $post_id;

			/** Don't save on autosave **/
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

			/** Check the user's permissions. **/
			if ( !current_user_can( 'edit_page', $post_id ) ) return;

			/** Check post status **/
			if ( get_post_status( $post_id ) == 'trash'  ) return;

			/** Unhook this function to prevent infinite looping **/
			remove_action( 'save_post_doctor', 'custom_metaboxes_saved' );

		}


	}

	$doctors = new doctors();

}