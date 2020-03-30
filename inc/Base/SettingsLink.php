<?php


/**
 * @package plugin run one
 */

namespace PluginRunOne\Base;

class SettingsLink extends BaseController
{

	public function register(){

		//settings link
		add_filter( "plugin_action_links_" .$this->plugin, array( $this, 'settings_link' ) );

	}

	public function settings_link( $links ) {

		$settings_link = '<a href="admin.php?page=ninja_plugin_one">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}
}
