<?php
/*
	Plugin Name: Plugin run two
	Plugin URI: #
	Description: Test plugin
	Version: 0.0
	Author: lukman.nakib@gmail.com-authlab
	License: GPL v3
	Text Domain:   PluginRunTwo


*/

defined( 'ABSPATH' ) or die( '!' );

if(!defined('PLUGIN_RUN_TWO_VERSION')){

    define('PLUGIN_RUN_TWO_VERSION','0.1');
    define('PLUGIN_RUN_TWO_MENU_NAME','Plugin Run Two');
    include dirname( __FILE__ ) . '/autoload.php';

    PluginRunTwo\Init::register_services();

    // plugin activation from BaseController
	register_activation_hook(__FILE__,
        function () {
            $act = new PluginRunTwo\Base\ActivatePlugin();
            $act->activate();
	});

    register_deactivation_hook( __FILE__ , function (){

         PluginRunTwo\Base\DeactivatePlugin::deactivate();
    });

} else {
    add_action('admin_init', function () {
        deactivate_plugins(plugin_basename(__FILE__));
    });
}


