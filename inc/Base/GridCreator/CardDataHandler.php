<?php


/**
 * @package PluginRunTwo
 * Card data handler
 */

namespace PluginRunTwo\Base\GridCreator;


class CardDataHandler
{
    public function getCardAdminData()
    {

        return array(

            'post_types'=>$this->getPostTypes(),
            'categories'=>$this->getCategories(),
        );
    }

    public function getPostTypes()
    {
        $post_data = array();
        //        all post types
        $post_types = get_post_types( array( 'show_ui' => true ,'public'   => true) ,'objects');

        foreach ($post_types as $post) {
            $post_data[]  = array('name'=>$post->name,'singular_name'=>$post->labels->singular_name);
        }

        return $post_data;

    }
    
    public function getPostData($args ='')
    {
        $args = array(
        );
    
        $posts = get_posts( $args );
        wp_send_json_success($posts);
    }
    protected function getCategories()
    {
        $allCategories = get_categories([
            'hide_empty' => 0,
            'order' => 'DESC',
            'order_by' => 'cat_ID'
        ]);

        $categories = [];

        foreach ($allCategories as $category) {
            $categories[] = [
                'category_id' => $category->cat_ID,
                'category_name' => $category->name
            ];
        }

        return $categories;
    }
    public function getPostTaxonomies($postType)
    {

        return array_map(function($taxonomy) {
            return [
                'name' => $taxonomy->name,
                'label' => $taxonomy->label
            ];
        }, get_object_taxonomies($postType, 'object'));
    }

    public function getSingleCardData($id)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'pluginone_cards';
        $data = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
        return $data;

    }
}
