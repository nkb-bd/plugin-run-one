<?php


/**
 * @package plugin run one 
 */

namespace PluginRunOne\Base;

class SettingsLink 
{
	
	public function register(){
	
		
		//settings link
		add_filter( "plugin_action_links_" .PLUGIN, array( $this, 'settings_link' ) );

	
	}


	public function settings_link( $links ) {

		$settings_link = '<a href="admin.php?page=plugin_one">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}
}