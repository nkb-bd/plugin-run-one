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

        if(isset($_GET['page']) && $_GET['page'] == 'ninja_plugin_one') {
            add_filter('admin_footer_text', function ($text) {
                return 'Thank you for checking plugin run one  : )';
            });
        }
        //js
        wp_enqueue_script(
            'plugin-run-one-card-admin',
            $this->plugin_url.'assets/admin/js/plugin-one-card-admin.js',
            '', //dependency
            $this->version,
            true //load in footer
        );

        //localize
        $user_id = get_current_user_id();

        $adminVars = array(
            'assets_url'          => $this->plugin_path . 'admin/',
            'ajaxurl'             => admin_url('admin-ajax.php'),
            'siteurl'             => site_url(),
            'user_id'             => $user_id,
        );
        wp_localize_script('plugin-run-one-card-admin', 'pluginRunOneCardAdmin', $adminVars);

        //styles
		wp_enqueue_style( 
			'plugin-run-on-style', 
			$this->plugin_url.'assets/admin/css/plugin-one-admin.css',
			'',
			$this->version
		);

		//js
		wp_enqueue_script( 
			'plugin-run-one',
			$this->plugin_url.'assets/admin/js/plugin-one-admin.js',
			'', //dependency
			$this->version,
			true //load in footer
		);

	}

}