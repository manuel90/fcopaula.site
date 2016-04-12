<?php
/*
Plugin Name: Fpsa Library
Plugin URI: localhost
Description: Plugin to create post types books.
Version: 1.0
Author: Manuel
Author URI: http://facebook.com/mlopezlara90
License: GPL2
*/

if( !defined('DS') ) {
	define('DS', DIRECTORY_SEPARATOR);
}

define('PATH_PLUGIN',dirname(__FILE__));

require_once('metaBoxes'.DIRECTORY_SEPARATOR.'FpsaBoxAuthors.php');
require_once('metaBoxes'.DIRECTORY_SEPARATOR.'FpsaBoxBooks.php');

class FpsaLibrary {

	var $boxAuthors = null;
	var $boxBooks = null;
	/**
	 * Construct Function
	 */
	public function __construct() {

		$this->boxAuthors = new FpsaBoxAuthors();
		$this->boxBooks = new FpsaBoxBooks();
		


		add_action( 'edit_user_profile', array($this, 'addBoxBooks') );
		
		/**
		 * Languages action
		 */
		add_action( 'plugins_loaded', array($this, 'load_textdomain') );

		/**
		 * Init action
		 */
		add_action( 'init', array($this,'initAction') );

		/**
		 * Meta Boxes action hook
		 */
		add_action( 'add_meta_boxes', array($this, 'addBoxes') );

		/**
		 * Activate and deactivate hooks
		 */
		register_activation_hook(__FILE__, array($this,'activate') );
		register_deactivation_hook( __FILE__, array($this,'deactivate') );


		/**
		 * Styles and Javascripts
		 */


		wp_register_script( 'fpsa_library', plugins_url( 'fpsa_library.js', __FILE__), array(), false, true );
 
		wp_enqueue_script( 'fpsa_library' );
		
		wp_register_style( 'fpsa_style', plugins_url( 'css/fpsa.css', __FILE__ ) );
    	wp_enqueue_style( 'fpsa_style' );

		add_action( 'admin_menu', array($this, 'addMenuAuthors') );

		$this->boxAuthors->ajaxActions();

		$this->boxBooks->ajaxActions();
		
		$this->boxBooks->wpAddBox();
		
	}

	/**
	 * Function call to add meta box on section admin profile page user
	 */
	public function addBoxBooks($user) {
		
		if( user_can($user, 'author') ) {
			do_meta_boxes('user-profile-author', 'advanced', $user);
		}
	}

	/**
	 * Function call to add a menu Author in the admin sidebar menu
	 */
	public function addMenuAuthors() {
	    add_menu_page(
	        __( 'Authors', 'fpsa_lang' ),
	        __( 'Authors', 'fpsa_lang' ),
	        'manage_options',
	        'users.php?role=author',
	        '',
	        'dashicons-admin-users',
	        26
	    );
	}


	/**
	 * Function to load the plugin language
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'fpsa_lang', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
	}

	/**
	 * Function call to set up "init" action hook
	 */
	public function initAction() {

		$labels = array(
	        'name'               => _x( 'Books', 'post type general name', 'fpsa_lang' ),
	        'singular_name'      => _x( 'Book', 'post type singular name', 'fpsa_lang' ),
	        'menu_name'          => _x( 'Books', 'admin menu', 'fpsa_lang' ),
	        'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'fpsa_lang' ),
	        'add_new'            => _x( 'Add New', 'book', 'fpsa_lang' ),
	        'add_new_item'       => __( 'Add New Book', 'fpsa_lang' ),
	        'new_item'           => __( 'New Book', 'fpsa_lang' ),
	        'edit_item'          => __( 'Edit Book', 'fpsa_lang' ),
	        'view_item'          => __( 'View Book', 'fpsa_lang' ),
	        'all_items'          => __( 'All Books', 'fpsa_lang' ),
	        'search_items'       => __( 'Search Books', 'fpsa_lang' ),
	        'parent_item_colon'  => __( 'Parent Books:', 'fpsa_lang' ),
	        'not_found'          => __( 'No books found.', 'fpsa_lang' ),
	        'not_found_in_trash' => __( 'No books found in Trash.', 'fpsa_lang' ),
	    );
		$options = array(
	        'labels'             => $labels,
	        'public'             => true,
	        'publicly_queryable' => true,
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        'query_var'          => true,
	        'rewrite'            => array( 'slug' => 'books' ),
	        'capability_type'    => 'post',
	        'has_archive'        => true,
	        'hierarchical'       => false,
	        'menu_position'      => null,
	        'menu_icon'			 => 'dashicons-book',
	        'supports'           => array( 'title', 'editor'/*, 'author'*/, 'thumbnail', 'excerpt', 'comments'),
	    );


		register_post_type ( 'fpsa-books', $options );
	}

	/**
	 * Function call to set up "add_meta_boxes" action hook
	 */
	public function addBoxes() {
		$this->boxAuthors->wpAddBox();
	}

	/**
	 * Function call when plugin is activated
	 */
	public function activate() {

		
		/**
		 * Here scripts when the plugin is activated 
		 */
	}

	/**
	 * Function call when plugin is deactivated
	 */
	public function deactivate() {

		/**
		 * here scripts when the plugin is deactivated
		 */
	}

}
/**
 * Instance of Plugin FpsaLibrary 
 */
$fpsa_library = new FpsaLibrary();

?>