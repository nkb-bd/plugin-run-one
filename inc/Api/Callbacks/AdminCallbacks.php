<?php


/**
 * @package pluginRunOne
 */

namespace PluginRunOne\Api\Callbacks;

use \PluginRunOne\Base\BaseController;


class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
        echo '<div id="onecardapp"></div>';
	}

	public function adminCpt()
	{
		 return require_once("$this->plugin_path/templates/cpt.php");
	}

	public function customTaxonomies()
	{
		 return require_once("$this->plugin_path/templates/custom_taxonomies.php");
	}



	public function pluginOneTextExample()
    {
        $value =  esc_attr( get_option('text_example') );
        echo '<input type="text" class="regular-text" name="text_example" value="'.$value.'" placeholder="Wrtie here.. " >';
	}

//



//
//    public function pluginOneOptionsGroup( $input)
//    {
//        return $input;
//    }
//

    public function adminTaxonomy()
    {
        return require_once("$this->plugin_path/templates/custom_taxonomies.php");

    }

    public function pluginOneFullName()
    {
        $value = esc_attr( get_option( 'full_name' ) );

        echo '<input type="text" class="regular-text" name="full_name" value="' . $value . '" placeholder=" Full Name" >';
    }


}
