<?php

/**
 * @package plugin run one
 */


namespace PluginRunOne\Base;

class BaseController
{
	public $plugin_path;
	public $plugin_url;
	public $plugin;
	public $version;
	public $base_setting_managers;

	public function __construct() {

		$this->plugin_path = plugin_dir_path(dirname( __FILE__ ,2) );
		$this->plugin_url = plugin_dir_url(dirname( __FILE__ ,2) );
		$this->plugin = plugin_basename(dirname( __FILE__ ,3).'/plugin-run-one.php' );
        $this->version = time();

        $this->base_setting_managers = array(
            'cpt_manager' => 'CPT Manager',
            'taxonomy_manager' => ' Taxonomy Manager',
            'card_manager' => ' Card Creator',
//            'gallery_manager' => 'Activate Gallery Manager',
//            'testimonial_manager' => 'Activate Testimonial Manager',
//            'templates_manager' => 'Activate Templates Manager',
//            'login_manager' => 'Activate Ajax Login/Signup',
//            'membership_manager' => 'Activate Membership Manager',
//            'chat_manager' => 'Activate Chat Manager'
        );

	}

    public function featureActivated(String $key)
    {
        $option = get_option('ninja_plugin_one');

        return isset($option[ $key ]) ? $option[ $key ] : false;
	}
}
