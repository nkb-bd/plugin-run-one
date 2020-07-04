<?php

/**
 * @package plugin run one
 */


namespace PluginRunTwo\Base;

class BaseController
{
	public $plugin_path;
	public $plugin_url;
	public $plugin;
	public $plugin_prefix;
	public $version;
	public $database_version;
	public $base_setting_managers;

	public function __construct() {

		$this->plugin_path = plugin_dir_path(dirname( __FILE__ ,2) );
		$this->plugin_url = plugin_dir_url(dirname( __FILE__ ,2) );
		$this->plugin = plugin_basename(dirname( __FILE__ ,3).'/plugin-run-one.php' );
		$this->plugin_prefix = 'plugin_run_one';
        $this->version = PLUGIN_RUN_TWO_VERSION;
        $this->database_version = '2';

        $this->base_setting_managers = array(
            'cpt_manager' => 'CPT Manager',
            'taxonomy_manager' => ' Taxonomy Manager',
            'card_manager' => ' Card Creator',

        );

	}

    public function featureActivated(String $key)
    {
        $option = get_option('ninja_plugin_one');
        return isset($option[ $key ]) ? $option[ $key ] : false;
	}
}
