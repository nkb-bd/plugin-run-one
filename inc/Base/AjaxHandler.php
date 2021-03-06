<?php

/**
 * @package plugin run one
 * ajax handler
 */


namespace PluginRunTwo\Base;

use PluginRunTwo\Base\BaseController;
use PluginRunTwo\Base\GridCreator\Render;

class AjaxHandler extends  BaseController
{
    public $cardDataProvider;
    public function register()
    {
        add_action('wp_ajax_plugin_run_two_card', array($this, 'handleAjax'));
        $this->cardDataProvider = new \PluginRunTwo\Base\GridCreator\CardDataHandler;

    }

    public function handleAjax()
    {

         $route = sanitize_text_field($_REQUEST['route']);

        $validRoutes = array(
            'update_modules' => 'updateModules',
            'get_cpt_data_by_id' => 'getCptDataById',
            'get_tax_data_by_id' => 'getTaxDataById',
            'cpt_export' => 'cptExport',
            'get_tax_list_data' => 'getTaxListDdata',
            'update_cpt' => 'updateCpt',
            'get_cpt_list_data' => 'getCptListData',
            'get_modules' => 'getModulesBase',
            'get_modules_db' => 'getModulesDb',
            'update_tax' => 'updateTax',
            'get_post_data' => 'getPostData',
            'get_taxonomies' => 'getTaxonomies',
            'get_list_data' => 'getListData',
            'get_post_data_by_id' => 'getPostDataById',
            'get_admin_preview_for_post'=>'getAdminPreviewPost'

        );

        if (isset($validRoutes[$route])) {

            do_action('PluginRunTwo/doing_ajax_events_' . $route);

            return $this->{$validRoutes[$route]}();
        }
    }

    public function updateModules()
    {
        $module_data = wp_unslash($_POST['data']);
        
        $success =    update_option('ninja_plugin_one',$module_data);
        wp_send_json_success(array(
            'response' => $success,
        ), 200);
    }

    public function getModulesDb()
    {
        $options =    get_option('ninja_plugin_one');
        wp_send_json_success(array(
            'data' => $options,
            'response' => 'success'
        ), 200);
    }
    public function updateTax()
    {
        $tax_data = $_POST['data'];
        $output = get_option('ninja_plugin_one_tax_option');

        if (isset($_POST["remove"])) {
            unset($output[$_POST["remove"]]);
        }

        if(empty($output)){

            $output = array($tax_data['taxonomy'] => $tax_data);
            $success = update_option('ninja_plugin_one_tax_option', $output);


        }else{

            foreach ($output as $key => $value) {
                if ($tax_data['taxonomy'] === $key) {
                    $output[$key] = $tax_data;
                } else {
                    $output[$tax_data['taxonomy']] = $tax_data;
                }
            }

            $success = update_option('ninja_plugin_one_tax_option', array_filter($output));
        }
        wp_send_json_success(array(
            'response' => $success,
        ), 200);

    }

    public function updateCpt()
    {

        $post_data = $_POST['data'];
        $output = array();


        $output = get_option('ninja_plugin_one_cpt_option');


        if (isset($_POST['remove']) ){

            unset($output[$_POST['remove']]); //deleting the cpt from delete form using the key

        }
        if(empty($output)){

            $output = array($post_data['post_type'] => $post_data);
            $success = update_option('ninja_plugin_one_cpt_option', $output);

        }else{
            foreach ($output as $key => $value){

                if ( $post_data['post_type'] == $key){

                    $output[$key] = $post_data;

                }else{
                    $output[$post_data['post_type']] = $post_data;
                }
            }

            $success = update_option('ninja_plugin_one_cpt_option', array_filter($output));

        }

//        $success = update_option('ninja_plugin_one_cpt_option', $output[$post_data['post_type']]);

        wp_send_json_success(array(
            'response' => $success,
        ), 200);
    }

    public function cptExport()
    {
        $key = $_REQUEST['id'];
        $data = new \PluginRunTwo\Base\CustomPostTypeController();
        $rednderData=  $data->exportCpt($key);
    }
    public function getCptDataById()
    {
        $cpt = $_POST['cpt_id'];

        $input = get_option( 'ninja_plugin_one_cpt_option' );
        //       cpt data from array key
        $cpt_data= $input[ $cpt ] ;
        wp_send_json_success(array(
            'data'=>  $cpt_data,
            'response' => 'success',
        ), 200);
    }

    public function getTaxDataById()
    {
        $key = $_POST['id'];

        $input = get_option( 'ninja_plugin_one_tax_option' );

        wp_send_json_success(array(
            'data'=>  $input[ $key ] ,
            'response' => 'success',
        ), 200);
    }
    public function getCptListData()
    {
        $options = get_option('ninja_plugin_one_cpt_option');

        wp_send_json_success(array(
            'data'=>  array_values($options),
            'response' => 'success',
        ), 200);



    }
    public function getTaxListDdata()
    {
        $options = get_option('ninja_plugin_one_tax_option');

        wp_send_json_success(array(
            'data'=>  array_values($options),
            'response' => 'success',
        ), 200);



    }
    public function getModulesBase()
    {
        $modules = array();


        // array for creating main dashboard option checkboxes
        $options =    get_option('ninja_plugin_one');
        $options =    json_decode ($options,true);
        foreach ( $this->base_setting_managers as $key => $value ) {
           


            $modules[] = array(
                'route' => $key,
                'title' => $value,
                'status' => isset($options[$key])?$options[$key]: false

            );
            
            
        }
        wp_send_json_success(array(
            'data'=> $modules,
            'response' => 'success',
        ), 200);
    }
    public function getPostData()
    {
         wp_send_json_success(array(
            'data'=>$this->cardDataProvider->getCardAdminData(),
            'response' => 'success',
        ), 200);
    }

    public function getPostDataById()
    {
        $id = $_REQUEST['card_id'];

        $data =  new \PluginRunTwo\Base\GridCreator\CardDataHandler;
        $rednderData=  $data->getSingleCardData($id);

        wp_send_json_success(array(
            'response' => 'success',
            'data' => $rednderData
        ), 200);

    }
    public function getTaxonomies()
    {

        $post = $_REQUEST['data'];

        wp_send_json_success(array(
            'data'=>$this->cardDataProvider->getPostTaxonomies($post),
            'response' => 'success',
        ), 200);

    }

   
    
    public function getAdminPreviewPost()
    {
       
        $render = new Render();
        echo $render->renderPreviewForAdmin();
        exit;
    }

    public function getListData()
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'pluginone_cards';
        $data = $wpdb->get_results("SELECT id, card_name,created_at FROM $table_name WHERE deleted= 0");

        wp_send_json_success(array(
            'response' => 'success',
            'data' => $data
        ), 200);

    }

}
