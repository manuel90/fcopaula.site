<?php

abstract class MasterFpsaBox {

	var $varsJS = array();
	var $config = array();

	/**
	 * function to render the box's template 
	 */
	abstract public function viewBox($params = null);
		
	public function __construct(array $config) {
		
		$this->config = $config;
		add_action( 'admin_init', array($this, 'addScripts') );
	}

	/**
	 * parent function to add javascripts
	 */
	public function addScripts() {
		
		$className = get_class($this);

		wp_register_script( $className.'JS', plugins_url( 'metaBoxes/'.$className.'.scripts.js', __FILE__), array('jquery', 'fpsa_library'), true, true );

		$this->varsJS = array_merge( $this->varsJS, $this->config['translation'] );

		wp_localize_script( $className.'JS', $className, $this->varsJS);
		 
		wp_enqueue_script( $className.'JS' );
	}

	/**
	 * parent function to register box
	 */
	public function wpAddBox($params = null) {
		add_meta_box( $this->config['id'], $this->config['title'], array($this,'viewBox'), $this->config['screens'], 'advanced', 'default', null);
	}

	/**
	 * function to add vars JS
	 */
	public function addJSVar($name, $value) {
		$className = get_class($this);

		$this->varsJS[$name] = $value;

		wp_localize_script( $className.'JS', $className, $this->varsJS );
	}
	
	/**
	 * this function is to formatter the response in ajax request
	 */
	public function formatterResponse($data, $status = 'OK', $message = '') {
		$result = array(
			'statusText' => $status,
			'data' => $data,
			'message' => $message
		);
		return json_encode($result);
	}

	/**
	 * function to remove the values
	 */
	public function removeData($type) {

		$typeA = $type;

		if($type == 'user') {
			$typeB = 'post';
			$option_typeA = 'fpsa_books';
			$option_typeB = 'fpsa_authors';
			$name = 'display_name';
		} else {
			$typeB = 'user';
			$option_typeA = 'fpsa_authors';
			$option_typeB = 'fpsa_books';	
			$name = 'post_title';
		}

		$values = call_user_func('get_'.$typeA.'_meta', $_POST['objID'], $option_typeA, true);

		if(array_key_exists($_POST['itemID'], $values)) {
			unset($values[$_POST['itemID']]);
		}
		
		$resultA = call_user_func('update_'.$typeA.'_meta', $_POST['objID'], $option_typeA, $values);
		

		$valuesB = call_user_func('get_'.$typeB.'_meta', $_POST['itemID'], $option_typeB, true);

		if(array_key_exists($_POST['objID'], $valuesB)) {
			unset($valuesB[$_POST['objID']]);
		}


		$resultB = call_user_func('update_'.$typeB.'_meta', $_POST['itemID'], $option_typeB, $valuesB);

		return self::formatterResponse([$resultA, $resultB]);

	}

	/**
	 * function to update the values
	 */
	public function updateData($type) {
		
		if($type == 'userdata') {
			$typeA = 'user';
			$typeB = 'post';
			$option_typeA = 'fpsa_books';
			$option_typeB = 'fpsa_authors';
			$name = 'display_name';
		} else {
			$typeA = 'post';
			$typeB = 'user';
			$option_typeA = 'fpsa_authors';
			$option_typeB = 'fpsa_books';	
			$name = 'post_title';
		}
		
		$data = call_user_func('get_'.$type, $_POST['objID']);

		$item = $_POST['values'];

		$oldValues = call_user_func('get_'.$typeA.'_meta', $data->ID, $option_typeA, true);
		

		$values = $oldValues ? $oldValues : array();

		if(!array_key_exists($item['id'], $values)) {
			$values[$item['id']] = array('id' => $item['id'], 'name' => $item['name']);
		}

		call_user_func('update_'.$typeA.'_meta', $data->ID, $option_typeA, $values);



		$oldValuesB = call_user_func('get_'.$typeB.'_meta', $item['id'], $option_typeB, true);
		$valuesB = $oldValuesB ? $oldValuesB : array();

		if(!array_key_exists($data->ID, $valuesB)) {
			$valuesB[$data->ID] = array('id' => $data->ID, 'name' => $data->$name);
		}
		call_user_func('update_'.$typeB.'_meta', $item['id'], $option_typeB, $valuesB);
		

		return self::formatterResponse($values);
	}
}


?>