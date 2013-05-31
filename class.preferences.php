<?php
//Класс для хранения настроек. Типичный представитель шаблона Синглтон.

Class Preferences {
	private $props[];

	private __construct() { }
	
	public static function getInstance() {
		if (empty(self::$instance)) {
			self::$instance = new Preferences;
		}
		return self::$instance;
	}
	
	public function setProperty($key, $val) {
		$this-props[$key] = $val;
	}
	
	public function getProperty($key) {
		return $this-props[$key]
	}
}

$pref = Preferences::getInstance();

$pref->setProperty("name", "Oleg");

?>