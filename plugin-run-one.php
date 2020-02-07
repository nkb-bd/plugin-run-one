<?php
/*
	Plugin Name: Plugin run one
	Plugin URI: #
	Description: Test plugin 
	Version: 0.0
	Author: lukman.nakib@gmail.com-authlab
	License: GPL v3
	Text Domain:   PluginRunOne


*/

defined( 'ABSPATH' ) or die( '!' );




include dirname( __FILE__ ) . '/autoload.php';


use PluginRunOne\Base\ActivatePlugin;
use PluginRunOne\Base\DectivatePlugin;

if (class_exists('PluginRunOne\Init')) {

	PluginRunOne\Init::register_services();

	register_activation_hook( __FILE__ , array( 'PluginRunOne\Base\ActivatePlugin', 'activate' ) );
	register_deactivation_hook( __FILE__ , array( 'PluginRunOne\Base\DeactivatePlugin', 'deactivate' ) );
}



 