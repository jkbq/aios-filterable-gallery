<?php
/**
 * This will run all the neccessary files, settings, and options
 *
 * @return void
 */
use AIOS\Gallery\Fileloader;
$files = array(
	'aios-filterable-gallery-config',
	'includes/aios-filterable-init.class'
);
Fileloader::load_files( $files );

Fileloader::load_directory( 'includes/post-type' );
Fileloader::load_directory( 'includes/classes' );
Fileloader::load_directory( 'includes/widgets' );