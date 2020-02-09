<?php


/**
 * @package pluginRunOne 
 */

namespace PluginRunOne\Pages;


//use MongoDB\Driver\Manager;
use PluginRunOne\Api\SettingsApi;
use PluginRunOne\Base\BaseController;
use PluginRunOne\Api\Callbacks\AdminCallbacks;
use PluginRunOne\Api\Callbacks\SanitizeCallbacksManager;

class Admin extends BaseController
{	

	public $page = array();

	public $callbacks;
	public $sanitize_callbacks_manager;

	public $subpages = array();

	public $settings;



	public function register(){


		$this->settings = new SettingsApi;
		$this->callbacks = new AdminCallbacks;

		$this->sanitize_callbacks_manager = new SanitizeCallbacksManager();
        //pages
		$this->setPages();
		$this->setSubPages();


		//admin custom fields
        $this->setSettings();
        $this->setSections();
        $this->setFields();

		
		
		// using method chaining
		$this->settings->addPages ( $this->pages )->withSubPages('Dashboard')->addSubPages( $this->subpages )->register();
		//settings link
		add_filter( "plugin_action_links_" . $this->plugin, array( $this, 'settings_link' ) );

	
	}

	public function setPages()
	{
		$this->pages = array(

			array(
				'page_title' => 'Plugin One', 
				'menu_title' => 'Plugin Run One ', 
				'capability' => 'manage_options', 
				'menu_slug' => 'ninja_plugin_one', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-store', 
				'position' => 110
			)
		);

	}

	public function setSubPages()
	{
		$this->subpages = array( 

			array(
				'parent_slug' => 'ninja_plugin_one', 
				'menu_title' => 'Custom Post Types', 
				'page_title' => 'CPT', 
				'capability' => 'manage_options', 
				'menu_slug' => 'ninja_plugin_one_cpt', 
				'callback' =>  array( $this->callbacks, 'customPostType' )  
				
			),
			array(
				'parent_slug' => 'ninja_plugin_one', 
				'menu_title' => 'Custom Taxonomies', 
				'page_title' => 'Taxonomy', 
				'capability' => 'manage_options', 
				'menu_slug' => 'ninja_plugin_one_tax', 
				'callback' =>  array( $this->callbacks, 'customTaxonomies' )
				
			),
		);
	}


    public function setSettings()
    {
        //        creating settings entry in database
        $args = array(
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'ninja_plugin_one',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )
            )
        );

        //base_setting_managers from base class
        //        $args = array();
        //
        //        foreach ( $this->base_setting_managers as $key => $value ) {
        //            $args[] = array(
        //                'option_group' => 'plugin_one_settings_group',
        //                'option_name' => $key,
        //                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )
        //            );
        //        }

        $this->settings->setSettings( $args );
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'plugin_one_index',
                'title' => 'Settings Manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'adminSectionManager' ),
                'page' => 'ninja_plugin_one'
            )
        );

        $this->settings->setSections( $args );
    }

    public function setFields()
    {
        //        $args = array(
        //            array(
        //                'id' => 'cpt_manager',
        //                'title' => 'Activate CPT Manager',
        //                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
        //                'page' => 'ninja_plugin_one',
        //                'section' => 'plugin_one_index',
        //                'args' => array(
        //                    'label_for' => 'cpt_manager',
        //                    'class' => 'ui-toggle'
        //                ),
        //            )
        //        );
        $args = array();

        foreach ( $this->base_setting_managers as $key => $value ) {
            $args[] = array(
                'id' => $key,
                'title' => $value,
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => $key,
                    'class' => 'ui-toggle',
                    'option_name' =>'ninja_plugin_one'
                )
            );
        }

        $this->settings->setFields( $args );
    }


	public function settings_link( $links ) {

		$settings_link = '<a href="admin.php?page=plugin-run-one">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}

	
	
}