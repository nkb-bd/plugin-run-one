<?php

/**
 * @package plugin run one 
 */


namespace PluginRunOne\Base;

class ActivatePlugin 
{
	
	public static function activate()
	{	
		flush_rewrite_rules();
	}
}