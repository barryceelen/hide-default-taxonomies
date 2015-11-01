<?php
/**
 * @package Hide Default Taxonomies
 * @version 0.3.0
 */

/**
 * Main plugin class.
 *
 * @package Hide Default Taxonomies
 * @author  Barry Ceelen <b@rryceelen.com>
 */
class Hide_Default_Taxonomies {

	public static function get_instance() {
		static $instance = null;
		if ( $instance === null ) {
			$instance = new Hide_Default_Taxonomies();
		}
		return $instance;
	}

	/**
	 * Add filters and actions.
	 *
	 * @since 0.1.0
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
	 * Enqueue styles.
	 *
	 * @since 0.1.0
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'hidetax', plugin_dir_url( __FILE__ ) . "/hide-default-taxonomies.css" );
	}

	/**
	 * Remove post submenu pages.
	 *
	 * @since 0.1.0
	 */
	public function remove_submenu_pages() {
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
	}

	/**
	 * Remove post meta boxes.
	 *
	 * @since 0.1.0
	 */
	public function remove_post_meta_boxes() {
		remove_meta_box( 'categorydiv',      'post', 'side'   );
		remove_meta_box( 'tagsdiv-post_tag', 'post', 'side'   );
	}

	/**
	 * Unregister sidebar widgets.
	 *
	 * @since 0.1.0
	 */
	public function unregister_widgets() {
		unregister_widget( 'WP_Widget_Categories' );
		unregister_widget( 'WP_Widget_Tag_Cloud' );
	}

	/**
	 * Remove nav menu meta boxes.
	 *
	 * @see http://wordpress.stackexchange.com/questions/97890/how-to-remove-a-metabox-from-menu-editor-page
	 *
	 * @since 0.1.0
	 */
	public function remove_nav_menu_meta_boxes() {
		remove_meta_box('add-category', 'nav-menus', 'side');
		remove_meta_box('add-post_tag', 'nav-menus', 'side');
	}

	/**
	 * Unset category and tag columns on edit.php.
	 *
	 * @since 0.1.0
	 */
	public function manage_post_posts_columns( $columns ) {
		if ( array_key_exists( 'categories', $columns ) ) {
			unset( $columns['categories'] );
		}
		if ( array_key_exists( 'tags', $columns ) ) {
			unset( $columns['tags'] );
		}
		return $columns;
	}
}
