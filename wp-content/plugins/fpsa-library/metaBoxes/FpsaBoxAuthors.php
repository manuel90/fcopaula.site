<?php

require_once(PATH_PLUGIN.DS.'MasterFpsaBox.php');

require_once(PATH_PLUGIN.DS.'templates'.DS.'MasterFpsaTemplate.php');


class FpsaBoxAuthors extends MasterFpsaBox {
	

	public function __construct() {

		parent::__construct(array(
			'id' => 'box_authors', 
			'title' => __('Authors Book', 'fpsa_lang'),
			'screens' => array('fpsa-books'),
			'translation' => array(
			    'txtRemove' => __( 'Delete', 'fpsa_lang' ),
			    'txtSelectAuthor' => __( '--- Select a User ---', 'fpsa_lang' ),
			    'txtNoSeletedUser' => __( 'Select a User', 'fpsa_lang' ),
			    'txtNoUsersAdded' => __( 'Authors assigned not found.', 'fpsa_lang' ),
			    'txtView' => __( 'View', 'fpsa_lang' )
			)
		));

	}

	/**
	 * Function to add scripts
	 */
	public function addScripts() {
		global $pagenow;
		if( $pagenow == 'post.php') {
			parent::addScripts();
		}
	}

	/**
	 * Function to add the ajax actions
	 */
	public function ajaxActions() {
		add_action( 'wp_ajax_fpsa-adduser', array('FpsaBoxAuthors', 'addAuthorOfBook') );

		add_action( 'wp_ajax_fpsa-availableusers', array('FpsaBoxAuthors', 'getAjaxAvailableUsers') );

		add_action( 'wp_ajax_fpsa-authors', array('FpsaBoxAuthors', 'getAjaxAuthors') );
		
		add_action( 'wp_ajax_fpsa-removeuser', array('FpsaBoxAuthors', 'deleteAuthorOfBook') );
	}

	/**
	 * This function returl the authors belongs to post type book 
	 */
	public function getAjaxAuthors() {
		$authors = get_post_meta($_POST['objID'], 'fpsa_authors', true);
		die( parent::formatterResponse($authors) );
	}

	/**
	 * Function call via ajax to get users author
	 */
	public function getAjaxAvailableUsers() {
		$users = self::getAvailableUsers($_POST['objID']);
		
		die( parent::formatterResponse($users) );
	}

	/**
	 * Function call via ajax to add author the book
	 */
	public function addAuthorOfBook() {

		die( parent::updateData('post') );
	}

	/**
	 * Functio call via Ajax to delete a book's author 
	 */
	public function deleteAuthorOfBook() {
		die( parent::removeData('post') );
	}


	/**
	 * Function call to add html content to box
	 */
	public function viewBox($params = null) {
		global $post;

		$this->addJSVar('postID', $post->ID);
		
		$parameters = array(
			
		);

		MasterFpsaTemplate::load('box-authors', $parameters);
	}

	/**
	 * this function return the users availables to assign the post type book
	 */
	static function getAvailableUsers($postID) {
		$authors = get_post_meta($postID, 'fpsa_authors', true);

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