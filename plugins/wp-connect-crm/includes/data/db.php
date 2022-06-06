<?php

function create_database_ctcrm_meta() {
	global $wpdb;
  $version = get_option( 'ctcrm_version', '1.0' );
	$charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE wp_ctcrm_options (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		meta_key varchar(255) NOT NULL,
    meta_value varchar(500) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	$sql .= "CREATE TABLE wp_ctcrm_meta (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		form_id mediumint(9) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

  $sql .= "CREATE TABLE wp_ctcrm_metadata (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    ctcrm_id mediumint(9) NOT NULL,
    meta_key varchar(255) NOT NULL,
    meta_value varchar(255) NOT NULL,
    UNIQUE KEY id (id)
  ) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
	if ( version_compare( $version, '2.0' ) < 0 ) {
    $sql = "CREATE TABLE wp_ctcrm_options (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
      meta_key varchar(255) NOT NULL,
      meta_value varchar(500) NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";

		$sql .= "CREATE TABLE wp_ctcrm_meta (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
      form_id mediumint(9) NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";

    $sql = "CREATE TABLE wp_ctcrm_metadata (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      ctcrm_id mediumint(9) NOT NULL,
      meta_key varchar(255) NOT NULL,
      meta_value varchar(255) NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

		dbDelta( $sql );
    update_option( 'ctcrm_version', '2.0' );
	}
}
create_database_ctcrm_meta();