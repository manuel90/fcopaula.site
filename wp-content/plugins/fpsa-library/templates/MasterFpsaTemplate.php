<?php


class MasterFpsaTemplate {
	

	public function __construct() {

	}

	static function load($template, array $data = array()) {

		foreach ($data as $key => $value) {
			${$key} = $value;
		}
		include_once("$template.tmpl.php");
	}
}



?>