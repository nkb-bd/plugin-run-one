<?php


/**
 * @package pluginRunOne
 * Custom Post Type
 */

namespace PluginRunOne\Base;


use \PluginRunOne\Base\BaseController;


class CustomPostTypeController extends BaseController
{

    public function register()
    {

        add_action( 'init', array($this, 'activate') );
    }

    function activate ()
    {
        register_post_type('plugin_one_product',
            array(
                'labels'=> array(
                    'name'=> 'One Products',
                    'singular_name'=> 'One Products',
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
    }

}