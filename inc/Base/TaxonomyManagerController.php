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
        if ($this->featureActivated('taxonomy_manager')=='false'){
            return ;
        }
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->tax_callbacks = new TaxonomyCallbacks();


        $this->setSubPages();

        $this->setSettings();
        
        $this->setSections();

        $this->setFields();


        // using method chaining creating sub pages
        $this->settings->addSubPages( $this->subpages )->register();

        
        $this->storeCustomTaxonomies();

        if ( ! empty( $this->taxonomies ) ) {
            add_action( 'init', array( $this, 'registerCustomTaxonomy' ));
        }


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
                'menu_slug' => 'ninja_plugin_one#/taxonomy_manager',
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
                'callback' => ''
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
                'callback' => array( $this->tax_callbacks, 'sectionManager' ),
                'page' => 'ninja_plugin_one_taxonomy'
            )
        );

        $this->settings->setSections( $args );
    }

    public function setFields()
    {
        $args = array(
            array(
                'id' => 'taxonomy',
                'title' => 'Custom Taxonomy ID',
                'callback' => array($this->tax_callbacks, 'textField'),
                'page' => 'ninja_plugin_one_taxonomy',
                'section' => 'ninja_plugin_one_tax_index',
                'args' => array(
                    'option_name' => 'ninja_plugin_one_tax_option',
                    'label_for' => 'taxonomy',
                    'placeholder' => 'eg. genre',
                    'array' => 'taxonomy'
                )
            ),
            array(
                'id' => 'singular_name',
                'title' => 'Singular Name',
                'callback' => array( $this->tax_callbacks, 'textField' ),
                'page' => 'ninja_plugin_one_taxonomy',
                'section' => 'ninja_plugin_one_tax_index',
                'args' => array(
                    'option_name' => 'ninja_plugin_one_tax_option',
                    'label_for' => 'singular_name',
                    'placeholder' => 'eg. Genre',
                    'array' => 'taxonomy'
                )
            ),
            array(
                'id' => 'hierarchical',
                'title' => 'Hierarchical',
                'callback' => array( $this->tax_callbacks, 'checkboxField' ),
                'page' => 'ninja_plugin_one_taxonomy',
                'section' => 'ninja_plugin_one_tax_index',
                'args' => array(
                    'option_name' => 'ninja_plugin_one_tax_option',
                    'label_for' => 'hierarchical',
                    'class' => 'ui-toggle',
                    'array' => 'taxonomy'
                )
            ),  
            array(
				'id' => 'objects',
				'title' => 'Post Types',
				'callback' => array( $this->tax_callbacks, 'checkboxPostTypesField' ),
				'page' => 'ninja_plugin_one_taxonomy',
				'section' => 'ninja_plugin_one_tax_index',
				'args' => array(
					'option_name' => 'ninja_plugin_one_tax_option',
					'label_for' => 'objects',
					'class' => 'ui-toggle',
					'array' => 'taxonomy'
				)
			)
        );

        $this->settings->setFields( $args );
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

    public function registerCustomTaxonomy()
    {
        foreach ($this->taxonomies as $taxonomy) {
           
            $objects = isset($taxonomy['objects']) ? array_keys($taxonomy['objects']) : null ;
         

            register_taxonomy( $taxonomy['rewrite']['slug'],  $objects , $taxonomy );
        }
    }

}
