<?php


/**
 * @package plugin run one 
 */

namespace PluginRunOne\Base;

class DeactivatePlugin 
{
	
	public static function deactivate()
	{
		flush_rewrite_rules();
	}
}