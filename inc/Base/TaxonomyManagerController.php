<?php


/**
 * @package pluginRunOne
 * Taxonomy manager
 */

namespace PluginRunOne\Base;


use \PluginRunOne\Base\BaseController;
use \PluginRunOne\Api\SettingsApi;
use PluginRunOne\Api\Callbacks\AdminCallbacks;


class TaxonomyManagerController extends BaseController
{
    public $subpages = array();

    public $settings;

    public $callbacks;


    public function register()
    {
        // check if activated in plugin settings from BaseController

        if (!$this->featureActivated('cpt_manager')){
            return ;
        }
        $this->settings = new SettingsApi;

        $this->callbacks = new AdminCallbacks;


        $this->setSubPages();


        // using method chaining creating sub pages
        $this->settings->addSubPages( $this->subpages )->register();


        add_action( 'init', array($this, 'activate') );
    }

    function activate ()
    {
        //        register_post_type('plugin_one_product',
        //            array(
        //                'labels'=> array(
        //                    'name'=> 'One Products',
        //                    'singular_name'=> 'One Products',
        //                ),
        //                'public' => true,
        //                'has_archive' => true,
        //            )
        //        );
    }

    public function setSubPages()
    {
        $this->subpages = array(

            array(
                'parent_slug' => 'ninja_plugin_one',
                'menu_title' => 'Taxonomy Manager',
                'page_title' => 'Taxonomy',
                'capability' => 'manage_options',
                'menu_slug' => 'ninja_plugin_one_taxonomy',
                'callback' =>  array( $this->callbacks, 'adminTaxonomy' ),

            )
        );
    }


}
