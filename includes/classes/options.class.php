<?php
/** List of filterable_gallery settings */
namespace AIOS\Gallery\Classses;

class Options {

    /**
     * Prevent undefined varible when saving empty data
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function Settings(){
        $filterable_gallery_settings = get_option( 'filterable_gallery_settings' );
        if( !empty( $filterable_gallery_settings ) ) extract( $filterable_gallery_settings );

        return array(
            'permastructure' 					=> ( isset( $permastructure ) ? $permastructure : 'filterable_gallery' ),
            'property_features' 				=> ( isset( $property_features ) ? $property_features : 'property-features' ),
            'property_types' 					=> ( isset( $property_types ) ? $property_types : 'property-types' ),
            'property_statuses' 				=> ( isset( $property_statuses ) ? $property_statuses : 'property-statuses' ),
            'property_neighborhoods' 			=> ( isset( $property_neighborhoods ) ? $property_neighborhoods : 'property-neighborhoods' ),
            'main_page' 						=> ( isset( $main_page ) ? $main_page : '' ),
            'active_page' 						=> ( isset( $active_page ) ? $active_page : '' ),
            'sold_page' 						=> ( isset( $sold_page ) ? $sold_page : '' ),
            'neighborhoods_page' 				=> ( isset( $neighborhoods_page ) ? $neighborhoods_page : '' ),
            'forms_schedule_showing_button' 	=> ( isset( $forms_schedule_showing_button ) ? $forms_schedule_showing_button : 'Schedule a Showing' ),
            'forms_schedule_showing' 			=> ( isset( $forms_schedule_showing ) ? $forms_schedule_showing : '' ),
            'forms_schedule_showing_title' 		=> ( isset( $forms_schedule_showing_title ) ? $forms_schedule_showing_title : 'Schedule a Showing' ),
            'forms_request_information_button' 	=> ( isset( $forms_request_information_button ) ? $forms_request_information_button : 'Request Info' ),
            'forms_request_information' 		=> ( isset( $forms_request_information ) ? $forms_request_information : '' ),
            'forms_request_information_title' 	=> ( isset( $forms_request_information_title ) ? $forms_request_information_title : 'Request Info' ),
            'interested_listing' 				=> ( isset( $interested_listing ) ? $interested_listing : '' ),
            'google_map_key' 					=> ( isset( $google_map_key ) ? $google_map_key : '' ),
            'google_map_exclude_homepage'		=> ( isset( $google_map_exclude_homepage ) ? $google_map_exclude_homepage : '' ),
            'google_map_type' 					=> ( isset( $google_map_type ) ? $google_map_type : 1 ),
            'google_map_zoom' 					=> ( isset( $google_map_zoom ) ? $google_map_zoom : 17 ),
            'google_map_icon' 					=> ( isset( $google_map_icon ) ? $google_map_icon : '' ),
            'disable_google_map' 				=> ( isset( $disable_google_map ) ? $disable_google_map : '' ),
            'flyer_description_max_characters' 	=> ( isset( $flyer_description_max_characters ) ? $flyer_description_max_characters : 300 )
        );
    }
}