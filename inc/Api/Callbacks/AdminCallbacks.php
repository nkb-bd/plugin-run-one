<?php


/**
 * @package PluginRunTwo
 */

namespace PluginRunTwo\Api\Callbacks;

use \PluginRunTwo\Base\BaseController;


class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
        do_action($this->plugin_prefix.'/render_admin_app');

        echo '<div id="onecardapp"></div>';
	}

	public function renderAdminCpt()
	{
        do_action($this->plugin_prefix.'/render_admin_cpt');
	}

	public function renderAdminTaxonomy()
	{
        do_action($this->plugin_prefix.'/renderAdminTaxonomy');
	}



	public function pluginOneTextExample()
    {
        $value =  esc_attr( get_option('text_example') );
        echo '<input type="text" class="regular-text" name="text_example" value="'.$value.'" placeholder="Wrtie here.. " >';
	}



}
