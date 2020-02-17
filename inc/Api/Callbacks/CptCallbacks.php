<?php


/**
 * @package pluginRunOne
 */

namespace PluginRunOne\Api\Callbacks;


class CptCallbacks
{


    public function adminSectionManager()
    {
        echo 'Manage your custom Post Types';
    }



//    public function checkboxField( $args)
//    {
//        $name = $args['label_for'];
//        $classes = $args['class'];
//        $option_name = $args['option_name'];
//        $checkbox = get_option( $option_name );
//        $checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;
//
//        echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
//  }

}
