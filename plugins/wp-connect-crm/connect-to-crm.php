<?php
/**
 * WordPress connect CRM plugin.
 *
 * @wordpress-plugin
 * Plugin Name: WordPress connect CRM
 * Plugin URI:  https://wordpress.org/plugins/CTCRM-content-analysis-for-yoast-seo/
 * Description: Ensure that Yoast SEO analyzes all Advanced Custom Fields 5.7+ content including Flexible Content and Repeaters.
 * Version:     0.1.0
 * Author:      Matthias Benoit
 * Author URI:  http://angrycreative.se
 * License:     GPL v3
 * Text Domain: wordpress-connect-crm
 * Domain Path: /wordpress-connect-crm/
 */

if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('CTCRM') ) :

class CTCRM {

  /** @var string The plugin version number. */
	var $version = '0.1.0';
	
	/** @var array The plugin settings array. */
	var $settings = array();
	
	/** @var array The plugin data array. */
	var $data = array();
	
	/** @var array Storage for class instances. */
	var $instances = array();

  /**
	 * __construct
	 *
	 * @date	03/05/22
	 * @since	0.1.0
	 *
	 * @param	void
	 * @return	void
	 */	
	function __construct() {
		// Do nothing.
	}

  /**
	 * initialize
	 *
	 * Sets up the CTCRM plugin.
	 *
	 * @date	28/09/13
	 * @since	5.0.0
	 *
	 * @param	void
	 * @return	void
	 */
	function initialize() {

		// Include utils.
		include_once('includes/utils/utils.php');

		// Include API.
		include_once('includes/api/get.php');
		include_once('includes/api/post.php');

    // Include admin.
		if( is_admin() ) {
			include_once('includes/admin/admin.php');
		}

		// Include databse.
		if( is_admin() ) {
			include_once('includes/data/db.php');
		}
	}

  /**
	 * define
	 *
	 * Defines a constant if doesnt already exist.
	 *
	 * @date	3/5/17
	 * @since	5.5.13
	 *
	 * @param	string $name The constant name.
	 * @param	mixed $value The constant value.
	 * @return	void
	 */
	function define( $name, $value = true ) {
		if( !defined($name) ) {
			define( $name, $value );
		}
	}
}

function ctcrm() {
	global $ctcrm;
	
	// Instantiate only once.
	if( !isset($ctcrm) ) {
		$ctcrm = new CTCRM();
		$ctcrm->initialize();
	}
	return $ctcrm;
}

add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
	wp_enqueue_style( 'ctcrm_css', WP_PLUGIN_URL . '/wp-connect-crm/assets/css/style.css', false, '1.0.0' );
}

// Instantiate.
ctcrm();

endif;