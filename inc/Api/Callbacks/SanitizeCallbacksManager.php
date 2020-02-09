<?php


/**
 * @package pluginRunOne 
 */

namespace PluginRunOne\Api\Callbacks;

use \PluginRunOne\Base\BaseController;


class SanitizeCallbacksManager extends BaseController
{
	
	public function checkboxSanitize( $input)
	{
        $output = array();

        foreach ($this->base_setting_managers as $key => $value){

            $output[$key] = ( isset( $input[$key] ) && $input[$key] ) ? true : false;
        }

        return $output;
	}

    public function adminSectionManager()
    {
        echo 'Manage the section and feature of this plugin';
	}

    public function checkboxField( $args)
    {
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];

        $checkbox = get_option( $option_name );
        echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ($checkbox[$name] ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
    }

}