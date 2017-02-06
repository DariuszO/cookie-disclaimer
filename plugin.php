<?php
/*
Plugin Name: Cookie disclaimer
Description: Cookie disclaimer
Version: 1.0
Author: Valerii Vasyliev
Author URI: http://gratta.com.ua/
Plugin URI: http://gratta.com.ua/
*/

namespace CD;

if(!defined('ABSPATH')) return;

define('CD_DIR', plugin_dir_path(__FILE__));

define('CD_URL', plugin_dir_url(__FILE__));

require __DIR__ . '/defines.php';

require __DIR__ . '/Module/Module.php';

require __DIR__ . '/Module/Backend.php';

require __DIR__ . '/Module/Frontend.php';


class Plugin {
    
	protected $_view;
    
	public function __construct() {

		new Module\Backend($this);
        
		new Module\Frontend($this);
	}
    
    public static function instance() {
		static $instance;
		if(!is_object($instance)) $instance = new self();
		return $instance;
	}
}

Plugin::instance();