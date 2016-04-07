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


class FpsaLibrary {


	/**
	 * Construct Function
	 */
	public function __construct() {
		
		/**
		 * Languages action
		 */
		add_action( 'plugins_loaded', array($this, 'load_textdomain') );

		/**
		 * Init action
		 */
		add_action( 'init', array('FpsaLibrary','initAction') );

		/**
		 * Meta Boxes action hook
		 */
		add_action( 'add_meta_boxes', array('FpsaLibrary', 'addBoxes') );

		/**
		 * Activate and deactivate hooks
		 */
		register_activation_hook(__FILE__, array('FpsaLibrary','activate') );
		register_deactivation_hook( __FILE__, array('FpsaLibrary','deactivate') );


		/**
		 * Styles and Javascripts
		 */
		//wp_enqueue_style();
		//wp_enqueue_script();

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
		$screens = array(
			'fpsa-books'
		);
		add_meta_box( 'box_authors', __('Author Books'), array('FpsaLibrary','boxAuthors'), $screens, 'advanced', 'default', null);
	}

	/**
	 * Function call to add html content to box
	 */
	public function boxAuthors($parameters) {
		/**
		 * Meta box authors
		 */
	}

	/**
	 * Function call when plugin is activated
	 */
	public function activate() {

		//self::installTables();
	}

	/**
	 * Function call when plugin is deactivated
	 */
	public function deactivate() {

		//self::uninstallTables();
	}

	/**
	 * Function created to script code database actions
	 * (OPTIONAL)
	 */
	public function installTables() {
		global $wpdb;

		$sql = "CREATE TABLE FpsaLibrary_books (
          wp_id bigint(20) NOT NULL auto_increment,
          wp_key varchar(255) default NULL,
          wp_value longtext,
          PRIMARY KEY  (`wp_id`)
        ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

    	$results = $wpdb->query($sql);
	}
	/**
	 * Function created to script code database actions
	 * (OPTIONAL)
	 */
	public function uninstallTables() {
		global $wpdb;

		$sql = "DROP TABLE FpsaLibrary_books;";

    	$results = $wpdb->query($sql);
	}
}
/**
 * Instance of Plugin FpsaLibrary 
 */
$fpsa_library = new FpsaLibrary();

?>