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

if(!defined('PLUGIN_RUN_ONE_VERSION')){

    define('PLUGIN_RUN_ONE_VERSION','0.1');
    include dirname( __FILE__ ) . '/autoload.php';

    PluginRunOne\Init::register_services();

    // plugin activation from BaseController
	register_activation_hook(__FILE__,
        function () {
            $act = new PluginRunOne\Base\ActivatePlugin();
            $act->activate();
	});

    register_deactivation_hook( __FILE__ , function (){

         PluginRunOne\Base\DeactivatePlugin::deactivate();
    });

} else {
    add_action('admin_init', function () {
        deactivate_plugins(plugin_basename(__FILE__));
    });
}


 