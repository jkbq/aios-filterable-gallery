<?php
/**
 * This will get all the templates for details page
 *
 * @since 1.0.0
 * @return void
 */
use AIOS\Gallery\Config;

$template_locations = Config::get_template_location( 'details-page' );
foreach ( $template_locations as $template_location ) {
	if ( $template_location[ 'is_active' ] === 'active-template' ) {
		require_once( $template_location[ 'template_file' ] );
	}
}