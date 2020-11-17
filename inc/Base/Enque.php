<?php


/**
 * @package PluginRunTwo
 */

namespace PluginRunTwo\Base;


use \PluginRunTwo\Base\BaseController;


class Enque extends BaseController
{

	public function register(){

		add_action( 'admin_enqueue_scripts', array($this, 'enque') );
	}


    function enque(){

        if(isset($_GET['page']) && $_GET['page'] == 'ninja_plugin_one') {
            add_filter('admin_footer_text', function ($text) {
                return 'Thank you for checking  the plugin   : )';
            });
            wp_enqueue_script(
                'plugin-run-one-card-admin',
                $this->plugin_url.'assets/admin/js/plugin-one-card-admin.js',
                '', //dependency
                 $this->version,
                true //load in footer
            );

            wp_enqueue_style(
                'plugin-run-one-card-public',
                $this->plugin_url.'assets/public/css/plugin-one-card-public.css',
                '', //dependency
                 $this->version,
            );

            //localize
            $user_id = get_current_user_id();

            $adminVars = array(
                'assets_url'          => $this->plugin_path . 'admin/',
                'ajaxurl'             => admin_url('admin-ajax.php'),
                'siteurl'             => site_url(),
                'user_id'             => $user_id,
                'date_format'         => get_option( 'date_format' )
            );
            wp_localize_script('plugin-run-one-card-admin', 'PluginRunTwoCardAdmin', $adminVars);

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

}
