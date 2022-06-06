<?php

/**
 * ctcrm_get_path
 *
 * Returns the plugin path to a specified file.
 *
 * @date	02/05/22
 * @since	0.1.0
 *
 * @param	string $filename The specified file.
 * @return	string
 */
function ctcrm_get_path( $filename = '' ) {
	return CTCRM_PATH . ltrim($filename, '/');
}

/*
 * ctcrm_include
 *
 * Includes a file within the CTCRM plugin.
 *
 * @date	03/03/22
 * @since	0.1.0
 *
 * @param	string $filename The specified file.
 * @return	void
 */ 
function ctcrm_include( $filename = '' ) {
	$file_path = ctcrm_get_path($filename);
	if( file_exists($file_path) ) {
		include_once($file_path);
	}
}