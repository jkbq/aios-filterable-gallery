<?php
/** This class will execute require files */
namespace AIOS\Gallery;

class Fileloader {
    
    /**
     * Loads all PHP files in a given directory.
     *
     * @param string $directory_name
     * @access public
     */
    public static function load_directory( $directory_name ) {
        $path = trailingslashit( AIOS_FILTERABLE_DIR . DIRECTORY_SEPARATOR . $directory_name );
        $file_names = glob( $path . '*.php' );
        foreach ( $file_names as $filename ) {
            if ( file_exists( $filename ) ) {
                require_once $filename;
            }
        }
    }

    /**
     * Loads specified PHP files from the plugin includes directory.
     *
     * @param array $file_names The names of the files to be loaded in the includes directory.
     * @access public
     */
    public static function load_files( $file_names = array() ) {
        foreach ( $file_names as $file_name ) {
            if ( file_exists( $path = AIOS_FILTERABLE_DIR . DIRECTORY_SEPARATOR . $file_name . '.php' ) ) {
                require_once $path;
            }
        }

    }

}