<?php

/**
 * @package Hide Default Taxonomies
 * @version 0.3.0
 */

/**
 * Plugin Name: Hide Default Taxonomies
 * Plugin URI: http://github.com/barryceelen/hide-default-taxonomies
 * Description: (Visually) removes most category and tag functionality from the WordPress admin
 * Author: Barry Ceelen
 * Author URI: http://github.com/barryceelen/
 * Version: 0.3.0
 * License: GPL2+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'class-hide-default-taxonomies.php' );
	add_action( 'plugins_loaded', array( 'Hide_Default_Taxonomies', 'get_instance' ) );
}
