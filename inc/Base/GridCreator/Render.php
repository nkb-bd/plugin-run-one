<?php


/**
 * @package PluginRunTwo
 * Card creator shortcode render
 */

namespace PluginRunTwo\Base\GridCreator;

use \PluginRunTwo\Base\BaseController;


class Render extends BaseController
{

    /**
     * Render constructor.
     */

    public function enque()
    {
        //styles for front end
        wp_enqueue_style(
            'plugin-run-on-style-card',
            $this->plugin_url.'assets/public/css/plugin-one-card-public.css',
            '',
            $this->version
        );

    }

    public function renderShortcode($id)
    {
        $data = $this->getFrontEndSetting($id);
        $this->enque();

        $args =  array(
            'post_type' => $data['post_type'],
            'cat' => $data['category_id'],
            'post_status' => 'publish',
            'orderby' => 'title',

        );

        $featured_img = $data['featured_img'];
        $cat_id = $data['category_id'];
        $card_name = $data['card_name'];
        $limit = $data['limit'];
        $display_class = $data['display_class'];
        $background_color = $data['background_color'];

        ob_start();
        //      card html
        require_once("$this->plugin_path/templates/card-grid.php");

        $content = ob_get_clean();

        return $content;

    }

    public function getFrontEndSetting($id)
    {
        $data =  new \PluginRunTwo\Base\GridCreator\CardDataHandler;

        $rednderData=  $data->getSingleCardData($id);

        if(!$rednderData){
            return false;
        }

        $basic_settings =  $rednderData->basicSettings;
        $basic_settings = json_decode($basic_settings);

        $card_name = $rednderData->card_name;
        $post_type = $basic_settings->post_type;
        $category_id = $basic_settings->category;
        $featured_img = $basic_settings->cardImage;
        $color = (isset($basic_settings->color))?$basic_settings->color :'';
        $limit = $basic_settings->limit;
        $view = (isset($basic_settings->view))?$basic_settings->view :'';


        $display_class =  ($view == 'grid') ? '':'display-grid';
        $color =  !empty($color) ? $color:'skyblue';
        $limit = $basic_settings->limit;

        $args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'orderby' => 'title',
            'featured_img' => $featured_img,
            'card_name' => $card_name,
            'limit' => $limit,
            'display_class' => $display_class,
            'background_color' => $color,
            'category_id' => $category_id,

        );

        return $args;

    }
}
