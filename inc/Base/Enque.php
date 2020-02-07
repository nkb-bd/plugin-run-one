<?php


/**
 * @package pluginRunOne 
 */

namespace PluginRunOne\Base;


use \PluginRunOne\Base\BaseController;


class Enque extends BaseController
{

	public function register(){
	
		add_action( 'admin_enqueue_scripts', array($this, 'enque') );
	}

	function enque(){

		wp_enqueue_style( 'plugin-run-on-style', $this->plugin_url.'assets/admin/css/plugin_one.css');
		wp_enqueue_script( 'plugin-run-one',$this->plugin_url.'assets/admin/js/plugin_one.js' );
	}

}