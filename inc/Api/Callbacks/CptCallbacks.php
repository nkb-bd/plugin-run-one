<?php


/**
 * @package PluginRunTwo
 */

namespace PluginRunTwo\Api\Callbacks;

class CptCallbacks
{

    public function cptSectionManager()
    {
        echo 'Create as many Custom Post Types as you want.';
    }

    public function cptSanitize( $input )
    {

//        $output = get_option('ninja_plugin_one_cpt_option');
//
//        if (isset($_POST['remove']) ){
//
//            unset($output[$_POST['remove']]); //deleting the cpt from delete form using the key
//            return $output;
//        }
//
//        if(empty($output)){
//
//            $input = array($input['post_type'] => $input);
//            return  $output = $input;
//        }
//
//
//        foreach ($output as $key => $value){
//            if ( $input['post_type'] === $key){
//               $output[$key] = $input;
//            }else{
//                $output[$input['post_type']] = $input;
//            }
//        }
////        echo    '<pre>';
////        print_r($output);exit;
//
//        return $output;
    }

    public function textField( $args )
    {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value ="";
        $readonly = '';

        if (isset($_POST["edit_post"]) ){

            $input = get_option( $option_name );
            $value= $input[ $_POST["edit_post"] ][ $name ];

            if ($name=='post_type'){
                $readonly = "readonly"; //diable input for post primary value
            }

        }


        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'.$value.'" placeholder="' . $args['placeholder'] . '" required="true" '.$readonly.'>';
    }

    public function checkboxField( $args )
    {
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];
        $checked = false;

        if (isset($_POST["edit_post"]) ){

            $checkbox = get_option( $option_name );
            $checked = isset($checkbox[$_POST["edit_post"]][$name]) ?: false;

        }


        echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . ' ><label for="' . $name . '"><div></div></label></div>';
    }
}

