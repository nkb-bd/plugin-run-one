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



        //js
        wp_enqueue_script(
            'plugin-run-one-card-admin',
            $this->plugin_url.'assets/dist/js/plugin-one-card-admin.js',
            '', //dependency
            $this->version,
            true //load in footer
        );

        //localize
        $user_id = get_current_user_id();

        $cardAdminVars = array(

            'assets_url'          => $this->plugin_path . 'dist/',
            'ajaxurl'             => admin_url('admin-ajax.php'),
            'user_id'          => $user_id,
        );
        wp_localize_script('plugin-run-one-card-admin', 'pluginRunOneCardAdmin', $cardAdminVars);


        //styles
		wp_enqueue_style( 
			'plugin-run-on-style', 
			$this->plugin_url.'assets/dist/css/plugin-one-admin.css',
			'',
			$this->version
		);

		//js
		wp_enqueue_script( 
			'plugin-run-one',
			$this->plugin_url.'assets/dist/js/plugin-one-admin.js',
			'', //dependency
			$this->version,
			true //load in footer
		);


	}

}