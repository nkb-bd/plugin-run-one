<?php


/**
 * @package pluginRunOne
 * Taxonomy manager
 */

namespace PluginRunOne\Base;


use PluginRunOne\Api\Callbacks\TaxonomyCallbacks;
use \PluginRunOne\Base\BaseController;
use \PluginRunOne\Api\SettingsApi;
use PluginRunOne\Api\Callbacks\AdminCallbacks;
use PluginRunOne\Api\Callbacks\CptCallbacks;


class TaxonomyManagerController extends BaseController
{
    public $settings;

    public $callbacks;

    public $subpages = array();

    public $taxonomies = array();

    public $tax_callbacks;




    public function register()
    {
        // check if activated in plugin settings from BaseController

        if (!$this->featureActivated('cpt_manager')){
            return ;
        }
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->tax_callbacks = new TaxonomyCallbacks();


        $this->setSubPages();


        $this->setSettings();
        $this->setSections();

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

    public function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'ninja_plugin_one_tax_settings',
                'option_name' => 'ninja_plugin_one_tax_option',
                'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
            )
        );

        $this->settings->setSettings( $args );
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'ninja_plugin_one_tax_index',
                'title' => 'Taxonomies Manager',
                'callback' => array( $this->cpt_callbacks, 'cptSectionManager' ),
                'page' => 'ninja_plugin_one_taxonomy'
            )
        );

        $this->settings->setSections( $args );
    }


}
