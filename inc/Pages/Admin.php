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
        $args = array(
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'cpt_manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )
            ),
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'taxonomy_manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )

            ),
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'media_widget',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )

            ),
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'gallery_manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )

            ),
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'testimonial_manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )

            ),
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'template_manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )

            ),
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'login_manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )

            ),
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'membership_manager',
                    'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )

            ),
            array(
                'option_group' => 'plugin_one_settings_group',
                'option_name' => 'chat_manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxSanitize' )

            )
        );

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
        $args = array(
            array(
                'id' => 'cpt_manager',
                'title' => 'Activate CPT Manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => 'cpt_manager',
                    'class' => 'ui-toggle'
                ),
            ),
            array(
                'id' => 'taxonomy_manager',
                'title' => 'Activate Taxonomy Manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => 'taxonomy_manager',
                    'class' => 'ui-toggle'
                ),
            ),
            array(
                'id' => 'media_widget',
                'title' => 'Activate Media Widget',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => 'media_widget',
                    'class' => 'ui-toggle'
                ),
            ),
            array(
                'id' => 'gallery_manager',
                'title' => 'Activate Gallery Manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => 'gallery_manager',
                    'class' => 'ui-toggle'
                ),
            ),
            array(
                'id' => 'testimonial_manager',
                'title' => 'Activate Testimonial Manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => 'testimonial_manager',
                    'class' => 'ui-toggle'
                ),
            ),
            array(
                'id' => 'template_manager',
                'title' => 'Activate Template Manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => 'template_manager',
                    'class' => 'ui-toggle'
                ),
            ),
            array(
                'id' => 'login_manager',
                'title' => 'Activate Login Manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => 'login_manager',
                    'class' => 'ui-toggle'
                ),
            ),
            array(
                'id' => 'membership_manager',
                'title' => 'Activate Membership Manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => 'membership_manager',
                    'class' => 'ui-toggle'
                ),
            ),
            array(
                'id' => 'chat_manager',
                'title' => 'Activate Chat Manager',
                'callback' => array( $this->sanitize_callbacks_manager, 'checkboxField' ),
                'page' => 'ninja_plugin_one',
                'section' => 'plugin_one_index',
                'args' => array(
                    'label_for' => 'chat_manager',
                    'class' => 'ui-toggle'
                ),
            ),
        );

        $this->settings->setFields( $args );
    }


	public function settings_link( $links ) {

		$settings_link = '<a href="admin.php?page=plugin-run-one">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}

	
	
}