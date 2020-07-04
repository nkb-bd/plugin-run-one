<?php


/**
 * @package PluginRunTwo
 * Taxonomy manager
 */

namespace PluginRunTwo\Base;


use PluginRunTwo\Api\Callbacks\TaxonomyCallbacks;
use \PluginRunTwo\Base\BaseController;
use \PluginRunTwo\Api\SettingsApi;
use PluginRunTwo\Api\Callbacks\AdminCallbacks;
use PluginRunTwo\Api\Callbacks\CptCallbacks;


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
        if ($this->featureActivated('taxonomy_manager')=='false'){
            return ;
        }
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->tax_callbacks = new TaxonomyCallbacks();


        $this->setSubPages();


        // using method chaining creating sub pages
        $this->settings->addSubPages( $this->subpages )->register();


        $this->storeCustomTaxonomies();

        if ( ! empty( $this->taxonomies ) ) {
            add_action( 'init', array( $this, 'registerCustomTaxonomy' ));
        }

    }


    public function setSubPages()
    {
        $this->subpages = array(

            array(
                'parent_slug' => 'ninja_plugin_one',
                'menu_title' => 'Taxonomy Manager',
                'page_title' => 'Taxonomy',
                'capability' => 'manage_options',
                'menu_slug' => 'admin.php?page=ninja_plugin_one#/taxonomy_manager',
                //load callback object and pass the call back function if needed
                'callback' =>  '',

            )
        );
    }



    public function storeCustomTaxonomies()
    {
        // get the taxonomies array
        $options = get_option( 'ninja_plugin_one_tax_option' ) ?: array();

        // store those info into an array
        foreach ($options as $option) {
            $labels = array(
                'name'              => $option['singular_name'],
                'singular_name'     => $option['singular_name'],
                'search_items'      => 'Search ' . $option['singular_name'],
                'all_items'         => 'All ' . $option['singular_name'],
                'parent_item'       => 'Parent ' . $option['singular_name'],
                'parent_item_colon' => 'Parent ' . $option['singular_name'] . ':',
                'edit_item'         => 'Edit ' . $option['singular_name'],
                'update_item'       => 'Update ' . $option['singular_name'],
                'add_new_item'      => 'Add New ' . $option['singular_name'],
                'new_item_name'     => 'New ' . $option['singular_name'] . ' Name',
                'menu_name'         => $option['singular_name'],
            );

            $this->taxonomies[] = array(
                'hierarchical'      => isset($option['hierarchical']) ? true : false,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => $option['taxonomy'] ),
                'objects'           => isset($option['objects']) ? $option['objects'] : null
            );

        }
        // register the taxonomy
    }




    /**
     * Register custom taxonomies from taxonomies array
     */
    public function registerCustomTaxonomy()
    {
        foreach ($this->taxonomies as $taxonomy) {

            $objects = isset($taxonomy['objects']) ? array_keys($taxonomy['objects']) : null ;
            register_taxonomy( $taxonomy['rewrite']['slug'],  $objects , $taxonomy );
        }
    }

}
