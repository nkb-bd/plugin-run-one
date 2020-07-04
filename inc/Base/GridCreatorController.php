<?php


/**
 * @package PluginRunTwo
 * Custom Post Type
 */

namespace PluginRunTwo\Base;


use \PluginRunTwo\Api\SettingsApi;
use \PluginRunTwo\Base\BaseController;
use PluginRunTwo\Api\Callbacks\CardManagerCallbacks;
use PluginRunTwo\Base\GridCreator\CardPreview;


class GridCreatorController extends BaseController
{
    public $settings;

    public $callbacks;


    public $subpages = array();

    public $cards_from_post = array();

    public function register()
    {
        if (  $this->featureActivated( 'card_manager' )=='false' ) {
            return;
        }
        // fluent form data
        $ff = new \PluginRunTwo\Base\GridCreator\FluentFormProvider();
        $ff->register();
        $this->settings = new SettingsApi();

        $this->callbacks = new CardManagerCallbacks();

        // $this->callbacks = new CptCallbacks();

        $this->setSubpages();

        // $this->setSections();

        // $this->setFields();

        $this->settings->addSubPages( $this->subpages )->register();

        // $this->storeCustomPostTypes();

        if ( ! empty( $this->custom_post_types ) ) {
            add_action( 'init', array( $this, 'registerCustomPostTypes' ) );
        }

        $this->registerShortcode();

        $setPreviewPage = new CardPreview();
        $setPreviewPage->register();

    }

    public function setSubpages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'ninja_plugin_one',
                'page_title' => 'Cards created from Post',
                'menu_title' => 'Card Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'ninja_plugin_one#/card_manager',
                'callback' => array( $this->callbacks, 'adminViewCard' )
            )
        );
    }



    public function registerShortcode()
    {

            // Register the shortcode
            add_shortcode('PluginRunTwo_card', function ($args) {
                $args = shortcode_atts(array(
                    'id'               => '',
                ), $args);

                if (!$args['id']) {
                    return;
                }

                $render = new \PluginRunTwo\Base\CardCreator\Render();
                return $render->renderShortcode($args['id']);

            });
    }




}
