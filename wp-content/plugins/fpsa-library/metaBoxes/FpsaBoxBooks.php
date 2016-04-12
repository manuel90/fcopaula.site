<?php

require_once(PATH_PLUGIN.DS.'MasterFpsaBox.php');

require_once(PATH_PLUGIN.DS.'templates'.DS.'MasterFpsaTemplate.php');


class FpsaBoxBooks extends MasterFpsaBox {
	
	public function __construct() {
		
		parent::__construct(array(
			'id' => 'box_books', 
			'title' => __('Books', 'fpsa_lang'),
			'screens' => array('user-profile-author'),
			'translation' => array( )
		));

	}

	public function wpAddBox() {
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


	static function actions() {
		add_action( 'wp_ajax_fpsa-adduser', array('FpsaBoxAuthors', 'addAuthorOfBook') );

		add_action( 'wp_ajax_fpsa-availableusers', array('FpsaBoxAuthors', 'getAjaxAvailableUsers') );

		add_action( 'wp_ajax_fpsa-authors', array('FpsaBoxAuthors', 'getAjaxAuthors') );
		

		add_action( 'wp_ajax_fpsa-removeuser', array('FpsaBoxAuthors', 'deleteAuthorOfBook') );
	}

	public function getAjaxAuthors() {
		$authors = get_post_meta($_POST['postID'], 'fpsa_book_authors', true);
		
		die( parent::formatterResponse($authors) );
	}

	/**
	 * Function call via ajax to get users author
	 */
	public function getAjaxAvailableUsers() {
		$users = self::getAvailableUsers($_POST['postID']);
		
		die( parent::formatterResponse($users) );
	}

	/**
	 * Function call via ajax to add author the book
	 */
	public function addAuthorOfBook() {

		$user = $_POST['user'];

		$oldValues = get_post_meta($_POST['postID'], 'fpsa_book_authors', true);

		$values = $oldValues ? $oldValues : array();

		if(!array_key_exists($user['id'], $values)) {
			$values[$user['id']] = array('id' => $user['id'], 'name' => $user['name']);
		}

		update_post_meta($_POST['postID'], 'fpsa_book_authors', $values);

		die( parent::formatterResponse($values) );
	}

	/**
	 * Functio call via Ajax to delete a book's author 
	 */
	public function deleteAuthorOfBook() {
		

		$values = get_post_meta($_POST['postID'], 'fpsa_book_authors', true);

		if(array_key_exists($_POST['userID'], $values)) {
			unset($values[$_POST['userID']]);
		}
		
		update_post_meta($_POST['postID'], 'fpsa_book_authors', $values);

		die( parent::formatterResponse([]) );
	}


	/**
	 * Function call to add html content to box
	 */
	public function viewBox() {
		echo '<h2>Probando el meta box</h2>';
	}

	static function getAvailableUsers($postID) {
		$authors = get_post_meta($postID, 'fpsa_book_authors', true);

		$users = array();

		$exclude = array();
		if($authors) {
			foreach ($authors as $author) {
				$exclude[] = $author['id'];
			}
		}

		$filter = array(
			'role' => 'author',
			'exclude' => $exclude
		);

		return get_users($filter);
	}

}

?>