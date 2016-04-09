<?php

abstract class MasterFpsaBox {

	static $varsJS = array();
		
	public function __construct(array $config) {
		add_meta_box( $config['id'], $config['title'], array($this,'viewBox'), $config['screens'], 'advanced', 'default', null);

		$className = get_class($this);

		wp_register_script( $className.'JS', plugins_url( 'metaBoxes/'.$className.'.scripts.js', __FILE__), array('jquery', 'fpsa_library'), true, true );

		self::$varsJS = array_merge( self::$varsJS, $config['translation'] );

		wp_localize_script( $className.'JS', $className,  self::$varsJS);
		 
		wp_enqueue_script( $className.'JS' );
	}

	public function addJSVar($name, $value) {
		$className = get_class($this);

		self::$varsJS[$name] = $value;

		wp_localize_script( $className.'JS', $className, self::$varsJS );
	}
	
	public function formatterResponse($data, $status = 'OK', $message = '') {
		$result = array(
			'statusText' => $status,
			'data' => $data,
			'message' => $message
		);
		return json_encode($result);
	}

	abstract public function viewBox();
}


?>