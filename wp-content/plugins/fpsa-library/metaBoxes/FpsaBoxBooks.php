<?php

require_once(PATH_PLUGIN.DS.'MasterFpsaBox.php');

require_once(PATH_PLUGIN.DS.'templates'.DS.'MasterFpsaTemplate.php');


class FpsaBoxBooks extends MasterFpsaBox {
	
	/**
	 * Construct function
	 */
	public function __construct() {
		
		parent::__construct(array(
			'id' => 'box_books', 
			'title' => __('Books', 'fpsa_lang'),
			'screens' => array('user-profile-author'),
			'translation' => array(
				'txtRemove' => __( 'Delete', 'fpsa_lang' ),
			    'txtSelectBook' => __( '--- Select a Book ---', 'fpsa_lang' ),
			    'txtNoSeletedBook' => __( 'Select a Book', 'fpsa_lang' ),
			    'txtNoUsersAdded' => __( 'The author don\'t contain books.', 'fpsa_lang' ),
			    'txtView' => __( 'View', 'fpsa_lang' )
			)
		));

	}

	/**
	 * this function add the scripts
	 */
	public function addScripts() {
		global $pagenow;

		if( $pagenow == 'user-edit.php') {
			parent::addScripts();
		}
	}

	/**
	 * Custom function to register metabox
	 */
	public function wpAddBox($params = null) {
		global $wp_meta_boxes;

		$id = $this->config['id'];
		$title = $this->config['title'];
		
		$context = 'advanced';
		$priority = 'default';
		
		$screen = new stdClass;

		$screen->id = $this->config['screens'][0];

		$page = $screen->id;

		$callback = array($this, 'viewBox');
		$callback_args = null;
 		
	    if ( !isset($wp_meta_boxes) )
	        $wp_meta_boxes = array();
	    if ( !isset($wp_meta_boxes[$page]) )
	        $wp_meta_boxes[$page] = array();
	    if ( !isset($wp_meta_boxes[$page][$context]) )
        	$wp_meta_boxes[$page][$context] = array();

        $wp_meta_boxes[$page][$context][$priority] = array();
 
    	$wp_meta_boxes[$page][$context][$priority][$id] = array('id' => $id, 'title' => $title, 'callback' => $callback, 'args' => $callback_args);

	}

	/**
	 * function to register ajax actions
	 */
	public function ajaxActions() {
		add_action( 'wp_ajax_fpsa-addbook', array('FpsaBoxBooks', 'addBookToAuthor') );

		add_action( 'wp_ajax_fpsa-availablebooks', array('FpsaBoxBooks', 'getAjaxAvailableBooks') );

		add_action( 'wp_ajax_fpsa-books', array('FpsaBoxBooks', 'getAjaxBooks') );

		add_action( 'wp_ajax_fpsa-removebook', array('FpsaBoxBooks', 'deleteBookOfAuthor') );
	}

	/**
	 * Function call via ajax to return the books what belong to an user
	 */
	public function getAjaxBooks() {
		$books = get_user_meta($_POST['objID'], 'fpsa_books', true);
		
		die( parent::formatterResponse($books) );
	}

	/**
	 * Function call via ajax to get users author
	 */
	public function getAjaxAvailableBooks() {
		$books = self::getAvailableBooks($_POST['objID']);
		
		die( parent::formatterResponse($books) );
	}

	/**
	 * Function call via ajax to add author to a book
	 */
	public function addBookToAuthor() {

		die( parent::updateData('userdata') );
	}

	/**
	 * Function call via Ajax to delete a author's book 
	 */
	public function deleteBookOfAuthor() {
		
		die( parent::removeData('user') );
	}


	/**
	 * Function call to add html content to box
	 */
	public function viewBox($user = null) {
		if($user !== null) {
			$this->addJSVar('userID', $user->ID);
		}
		MasterFpsaTemplate::load('box-books');
	}

	static function getAvailableBooks($userID) {
		$books = get_user_meta($userID, 'fpsa_books', true);

		$exclude = array();
		if($books) {
			foreach ($books as $book) {
				$exclude[] = $book['id'];
			}
		}

		$filter = array(
			'post_type' => 'fpsa-books',
			'exclude' => $exclude
		);

		return get_posts($filter);
	}

}

?>