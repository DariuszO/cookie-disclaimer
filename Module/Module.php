<?php
namespace CD\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Module {
    
	protected $_plugin;
	public function __construct($plugin) {
		$this->_plugin = $plugin;
		$this->_init();
	}
	public function get_plugin() {
		return $this->_plugin;
	}
	public function get_module_name() {
                $classname = get_called_class();
                $_ = explode('\\', $classname);
                return $_[count($_)-1];
    }
	abstract protected function _init();
}