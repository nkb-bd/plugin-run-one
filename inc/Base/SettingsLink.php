<?php


/**
 * @package plugin run one
 */

namespace PluginRunTwo\Base;

class SettingsLink extends BaseController
{

	public function register(){

		//settings link
		add_filter( "plugin_action_links_" .$this->plugin, array( $this, 'settings_link' ) );

	}

	
}
