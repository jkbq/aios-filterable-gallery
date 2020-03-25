<?php
namespace AIOS\Gallery;

class Config{

    /**
     * Option Tabs.
     *
     * @since 1.0.0
     *
     * @access public
     * @return void
     */
    public static function options_tabs( $tabs = array() ) {
        $tabs = array(
            '' => array(
                'url' 		=> 'main-page',
                'title' 	=> 'Gallery Page',
                'child' 	=> array(
                    array(
                        'url' 		=> 'main-page-themes',
                        'title' 	=> 'Themes',
                        'function'	=> 'main-page/themes.php'
                    ),
                    array(
                        'url' 		=> 'main-page-options',
                        'title' 	=> 'Options',
                        'function'	=> 'main-page/options.php'
                    )
                )
            ),

            'details-page' => array(
                'url' 		=> 'details-page',
                'title' 	=> 'Gallery Details Page',
                'child' 	=> array(
                    array(
                        'url' 		=> 'details-page-themes',
                        'title' 	=> 'Themes',
                        'function'	=> 'details-page/themes.php'
                    ),
                    array(
                        'url' 		=> 'details-page-options',
                        'title' 	=> 'Options',
                        'function'	=> 'details-page/options.php'
                    )
                )
            ),
        );
        return array_filter( $tabs );
    }

    /**
     * Theme Locations Paths.
     *
     * @since 1.0.0
     *
     * @access public
     * @return void
     */
    public static function template_location( $theme_path ) {
        $folder = array(
            array(
                'path' => AIOS_FILTERABLE_DIR . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $theme_path . DIRECTORY_SEPARATOR, /** This resides in the plugin **/
                'url' => AIOS_FILTERABLE_URL . 'templates/' . $theme_path . '/',
                'location_name' => 'core'
            ),
            array(
                'path' => realpath( get_stylesheet_directory() ) . DIRECTORY_SEPARATOR . 'filterable-gallery-templates' . DIRECTORY_SEPARATOR . $theme_path . DIRECTORY_SEPARATOR, /** This resides in the current theme or child theme. Gets deleted when theme is deleted.  **/
                'url' => get_stylesheet_directory_uri() . '/filterable-gallery-templates/' . $theme_path . '/',
                'location_name' => 'active-theme'
            ),
            array(
                'path' => realpath( WP_CONTENT_DIR ) . DIRECTORY_SEPARATOR . 'filterable-gallery-templates' . DIRECTORY_SEPARATOR . $theme_path . DIRECTORY_SEPARATOR, /** This resides in the wp-content folder to prevent deleting when upgrading themes. Recommended location. **/
                'url' => WP_CONTENT_URL . '/filterable-gallery-templates/' . $theme_path . '/',
                'location_name' => 'wp-content'
            )
        );

        return array_filter( $folder );
    }

    /**
     * List of Themes
     *
     * @since 1.0.0
     *
     * @access public
     * @return void
     */
    public static function get_template_location( $page_theme ) {
        $lists 					= array();
        $template_locations 	= self::template_location( $page_theme );
        $templates 				= array();
        $current_template 		= get_option( 'gallery-' . $page_theme, 'default-core' );

        /** BEGIN: Check if Template Locations is Array **/
        if ( is_array( $template_locations ) ) {
            foreach ( $template_locations as $template_location ) {
                /** BEGIN: Check if Template Locations is DIR **/
                if( is_dir( $template_location['path'] ) ) {
                    /** BEGIN: Scan DIR **/
                    if( $all_files = scandir( $template_location['path'] ) ){
                        /** Remove DIR **/
                        $files = array_diff( $all_files, array( '.', '..' ) );
                        /** BEGIN: Check if each DIR **/
                            foreach ( $files as $file) {
                                $template_path 				= $template_location['path'] . $file;
                                $template_file 				= $template_location['path'] . $file . DIRECTORY_SEPARATOR . 'options.php';
                                $template_functions 		= $template_location['path'] . $file . DIRECTORY_SEPARATOR . 'functions.php';
                                $template_screenshot 		= $template_location['url'] . $file . '/screenshot.jpg';
                                $template_screenshot_dir 	= $template_location['path'] . $file . DIRECTORY_SEPARATOR . 'screenshot.jpg';
                                /** BEGIN: Check if is directory and a file exists and duplicate folder **/
                                if ( is_dir( $template_path ) && @file_exists( $template_functions ) && !in_array( $file, $templates) ) {
                                    array_push( $templates, $file );
                                    $name 					= ucwords( str_replace( '-', ' ', $file ) );
                                    $fname 					= $file . '-' . $template_location['location_name'];
                                    $is_active 				= ( $current_template == $fname ? 'active-template' : '' );
                                    $template_shortpath 	= str_replace( realpath( WP_CONTENT_DIR ) . DIRECTORY_SEPARATOR, '', $template_path );
                                    $template_screenshot 	= @file_exists( $template_screenshot_dir ) ? $template_screenshot : AIOS_FILTERABLE_URL_ASSETS_IMAGES . '/screenshot.jpg';

                                    $lists[$fname] = array(
                                        'template_name' 		=> $name,
                                        'template_fullname' 	=> $fname,
                                        'template_path' 		=> $template_path,
                                        'template_file' 		=> $template_file,
                                        'template_functions' 	=> $template_functions,
                                        'template_screenshot' 	=> $template_screenshot,
                                        'is_active' 			=> $is_active,
                                        'location_name'			=> $template_location['location_name']
                                    );
                                }
                                /** END: to Check if is directory and a file exists **/
                            }
                        /** END: Check if each DIR **/
                    }
                    /** END: Scan DIR **/
                }
                /** END: heck if Template Locations is DIR **/
            }
        }
        /** END: Check if Template Locations is Array **/

        return array_filter( $lists );
    }

}