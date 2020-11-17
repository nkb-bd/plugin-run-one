<?php


/**
 * @package PluginRunTwo
 */

namespace PluginRunTwo\Pages;

use PluginRunTwo\Api\SettingsApi;
use PluginRunTwo\Base\BaseController;
use PluginRunTwo\Api\Callbacks\AdminCallbacks;
use PluginRunTwo\Api\Callbacks\SanitizeCallbacksManager;

class Dashboard extends BaseController
{
	public $page = array();
	public $callbacks;
	public $subpages = array();
	public $settings;

	public function register(){

		$this->settings = new SettingsApi;            // settings api for adding menu and pages
		$this->callbacks = new AdminCallbacks;        // callbacks api for adding callback function, currently not needed as vue will handle this
		$this->setPages();                            // page and menu
        if (is_admin()) {
            $this->adminAjaxHandler();
        }
		// using method chaining creating page and sub pagesÅ
		$this->settings->addPages ( $this->pages )->withSubPages('Dashboard')->addSubPages( $this->subpages )->register();
        add_filter( "plugin_action_links_" .$this->plugin, array( $this, 'settings_link' ) );
        
        
    }

	public function setPages()
	{
		$this->pages = array(

			array(
				'page_title' => PLUGIN_RUN_TWO_MENU_NAME,
				'menu_title' => PLUGIN_RUN_TWO_MENU_NAME,
				'capability' => 'manage_options',
				'menu_slug' => 'ninja_plugin_one',
				'callback' => array( $this->callbacks, 'adminDashboard' ),
				'icon_url' => 'dashicons-marker',
				'position' => 25
			)
		);
	}


    public function adminAjaxHandler()
    {
        $adminAjax = new \PluginRunTwo\Base\AjaxHandler;
        $adminAjax->register();
    }
    public function settings_link( $links ) {
        
        $settings_link = '<a href="admin.php?page=ninja_plugin_one">Settings</a>';
        array_push( $links, $settings_link );
        return $links;
    }

}
