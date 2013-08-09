<?php

/**
 * @package Hide Default Taxonomies
 * @version 0.2
 */

/*
 * Plugin Name: Hide Default Taxonomies
 * Plugin URI: http://github.com/barryceelen/hide-default-taxonomies
 * Description: (Visually) removes most category and tag functionality from WordPress admin
 * Author: Barry Ceelen
 * Author URI: http://github.com/barryceelen/
 * Version: 0.2
 * License: GPL2+
 */

add_action( 'plugins_loaded', array( 'HideDefaultTaxonomies', 'get_instance' ) );

class HideDefaultTaxonomies {

	public static function get_instance() {
		static $instance = null;
		if ( $instance === null ) {
			$instance = new HideDefaultTaxonomies();
		}
		return $instance;
	}

	/**
	 * Add filters and actions
	 */

	private function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'remove_submenu_pages' ) );
		add_action( 'add_meta_boxes', array( $this, 'remove_post_meta_boxes' ) );
		add_action( 'widgets_init', array( $this, 'unregister_widgets' ) );
		add_action( 'admin_head-nav-menus.php', array( $this, 'remove_nav_menu_meta_boxes' ) );
		add_filter( 'manage_post_posts_columns', array( $this, 'manage_post_posts_columns' ) );
	}

	/**
	 * Enqueue scripts and/or styles
	 */

	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'hidetax', plugin_dir_url( __FILE__ ) . "/hide-default-taxonomies.css" );
	}

	/**
	 * Remove post submenu pages
	 */

	public function remove_submenu_pages() {
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
	}

	/**
	 * Remove post meta boxes
	 */

	public function remove_post_meta_boxes() {
		remove_meta_box( 'categorydiv',      'post', 'side'   );
		remove_meta_box( 'tagsdiv-post_tag', 'post', 'side'   );
	}

	/**
	 * Unregister sidebar widgets
	 */

	public function unregister_widgets() {
		unregister_widget( 'WP_Widget_Categories' );
		unregister_widget( 'WP_Widget_Tag_Cloud' );
	}

	/**
	 * Remove nav menu meta boxes
	 *
	 * via: http://wordpress.stackexchange.com/questions/97890/how-to-remove-a-metabox-from-menu-editor-page
	 */

	public function remove_post_nav_menu_meta_boxes() {
	  remove_meta_box('add-category', 'nav-menus', 'side');
	  remove_meta_box('add-post_tag', 'nav-menus', 'side');
	}

	/**
	 * Unset category and tag columns on edit.php
	 */

	public function manage_post_posts_columns( $columns ) {
		if ( array_key_exists( 'categories', $columns ) )
			unset( $columns['categories'] );
		if ( array_key_exists( 'tags', $columns ) )
			unset( $columns['tags'] );
		return $columns;
	}

}
