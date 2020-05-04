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
            'main_page' 						=> ( isset( $main_page ) ? $main_page : '' ),
        );
    }
}