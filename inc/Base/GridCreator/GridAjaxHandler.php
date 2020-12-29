<?php


namespace PluginRunTwo\Base\GridCreator;
use \PluginRunTwo\Base\BaseController;

class GridAjaxHandler extends BaseController
{
    public function register()
    {
        add_action('wp_ajax_plugin_run_two_grid', array($this, 'handleAjax'));
        
    }
    public function handleAjax()
    {
        
        $route = sanitize_text_field($_REQUEST['route']);
        
        $validRoutes = array(
            'get_wp_posts'               => 'getWpPostData',
            'get_fluentform_forms'       => 'getFluentformForms',
            'get_fluentform_form_fields' => 'getFluentformFormFields',
            'get_fluent_data'            => 'getFluentData',
            'get_ninja_tables'           => 'getNinjaTables',
            'get_ninja_tables_column'    => 'getNinjaTablesColumn',
            'get_ninja_table_data'       => 'getNinjaTableData',
            'get_new_grid_key'           => 'getNewGridKey',
            'update_card'                => 'updateCard',
            'get_card_data_by_id'        => 'getCardDataById',


        );
        
        if (isset($validRoutes[$route])) {
            
            do_action('PluginRunTwo/doing_ajax_events_' . $route);
            
            return $this->{$validRoutes[$route]}();
        }
    }
    
    public function getWpPostData()
    {
        
        $postData = $_REQUEST['data'];
        
        $post_types_array = array();
        //        all post types
        $post_types = get_post_types( array( 'show_ui' => true ,'public'   => true) ,'objects');
    
        foreach ($post_types as $post) {
            $post_types_array[]  = $post->name;
        }
        
        $args = array(
            'post_status' => 'publish',
            'post_type'   => $postData['postType'],
            'numberposts' => $postData['limit']
            
        );
        if(!empty($postData['category'])){
            $args['cat'] = $postData['category'];
        }
    
        $limit_post_content = isset($postData['content_limit']) ? $postData['content_limit']: 30;
    
    
        $posts = get_posts( $args );
        $formattedPost = [];
        foreach ($posts as $key => $val){
            $formattedPost[] =  (array)$val;
            
            
            if(shortcode_exists($val->post_content)){
                $formattedPost[$key]['test'] = 'test';
            }
            $content =  do_shortcode($val->post_content);
    
            $formattedPost[$key]['post_title']            = wp_trim_words ( $val->post_title, 40, '...' );
            $formattedPost[$key]['formatted_content']     = wp_trim_words ( $content, $limit_post_content, '...' );
            $formattedPost[$key]['formatted_date']        = get_the_date ( '', $val->ID );
            $formattedPost[$key]['formatted_author_name'] = get_the_author_meta ( 'user_nicename', $val->post_author );
            $formattedPost[$key]['formatted_author_link'] = get_the_author_meta ( 'user_url', $val->post_author );
            $img_url                                      = (get_the_post_thumbnail_url ( $val->ID, 'post-thumbnail' )) ? get_the_post_thumbnail_url ( $val->ID, 'post-thumbnail' ) : $this->plugin_url . 'assets/public/blank.png';
    
            $formattedPost[$key]['formatted_thumbnail'] = $img_url;
            $formattedPost[$key]['formatted_link']      = get_permalink ( $val->ID );
            
            if($avatar = get_avatar_url(get_the_author_meta($val->post_author)) ){
                $formattedPost[$key]['formatted_author_image'] = $avatar ;
            }else{
                $formattedPost[$key]['formatted_author_image'] ='https://secure.gravatar.com/avatar/1e01ea5e304a25eaec5bec5560e619a7?s=64&d=mm&r=g' ;
            }
        
        }
    
        wp_send_json_success($formattedPost);
    }
    
    public function formatDate($posts){
        
            $posts['post_date'] = 'x';
            return $posts;
    }
    
    public function getFluentformForms()
    {
        
        if (function_exists('wpFluentForm')) {
            $forms = wpFluent()->table('fluentform_forms')->select(array('id', 'title'))->get();
            wp_send_json_success($forms, 200);
            wp_die();
        }
    }
    
    public function getFluentformFormFields()
    {
        
    
        $form = wpFluentForm('FluentForm\App\Modules\Form\Form');
        $formFieldParser = wpFluentForm('FluentForm\App\Modules\Form\FormFieldsParser');
    
        // Default meta data fields.
        $labels = [
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'serial_number', 'label' => 'Serial Number'],
            ['name' => 'status', 'label' => 'Status']
        ];
    
        $form = $form->fetchForm(intval($_REQUEST['form_Id']));
        $inputs = $formFieldParser->getEntryInputs($form);
        foreach ($formFieldParser->getAdminLabels($form, $inputs) as $key => $value) {
            $labels[] = array('name' => $key, 'label' => $value);
        }
    
        wp_send_json_success($labels, 200);
        
    }
    public function getFluentData($data='', $tableId='', $perPage = 9999, $offset = '0')
    {
        if (function_exists('wpFluentForm')) {
          
            $formData = $_REQUEST['data'];
            
            $fields = $formData['fieldData'] ;
            $limit  = $formData['limit'] ;
            
            $formId = $formData['formId'];
            // we need this short-circuite to overwrite fluentform entry permissions
            add_filter('fluentform_verify_user_permission_fluentform_entries_viewer', array($this, 'addEntryPermission'));
            
//            $formId = get_post_meta($tableId, '_ninja_tables_data_provider_ff_form_id', true);
            $entries = wpFluentForm('FluentForm\App\Modules\Entries\Entries')->_getEntries(
                intval($formId),
                isset($_GET['page']) ? intval($_GET['page']) : 1,
                intval($limit),
                $this->getOrderBy(),
                'all',
                null
            );
            
            // removing this short-circuite to overwrite fluentform entry permissions
            remove_filter('fluentform_verify_user_permission_fluentform_entries_viewer', array($this, 'addEntryPermission'));
            
//            $columns = $this->getTableColumns($tableId);
            
            $formattedEntries = array();
            foreach ($entries['submissions']['data'] as $key => $value) {
                // Prepare the entry with the selected columns.
                $value->user_inputs = $this->prepareEntry($value, $fields);
                
                $formattedEntries[] = array(
                    'id' => $value->id,
                    'values' => $value->user_inputs
                );
            }
            
            return wp_send_json_success(
                $formattedEntries,
                $entries['submissions']['paginate']['total']
            );
        }
        
        return [];
    }
    private function getOrderBy($tableId='')
    {
        return 'DESC';
    }
    private function prepareEntry($entry, $columns = [])
    {
        $entry->user_inputs = $this->addEntryMeta($entry, $columns);
        
        return array_intersect_key(
            $entry->user_inputs, array_combine($columns, $columns)
        );
    }
    private function addEntryMeta($value, $columns = [])
    {
        return array_merge($value->user_inputs, array_intersect_key(
            [
                'id'            => $value->id,
                'serial_number' => $value->serial_number,
                'status'        => $value->status
            ],
            array_combine($columns, $columns)
        ));
    }
    public function getNinjaTables(){
        $perPage = intval(isset($_REQUEST['per_page'])) ?: 999999;
    
        $currentPage = intval(isset($_GET['page']));
    
        $skip = $perPage * ($currentPage - 1);
    
        $args = array(
            'posts_per_page' => $perPage,
            'offset'         => 0,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_type'      => 'ninja-table',
            'post_status'    => 'any',
        );
    
        if (isset($_REQUEST['search']) && $_REQUEST['search']) {
            $args['s'] = sanitize_text_field($_REQUEST['search']);
        }
    
        $tables = get_posts($args);
    
        foreach ($tables as $table) {
            $table->preview_url = site_url('?ninjatable_preview=' . $table->ID);
            $dataSourceType = ninja_table_get_data_provider($table->ID);
            $table->dataSourceType = $dataSourceType;
            if ($dataSourceType == 'fluent-form') {
                $fluentFormFormId = get_post_meta($table->ID, '_ninja_tables_data_provider_ff_form_id', true);
                if ($fluentFormFormId) {
                    $table->fluentfrom_url = admin_url('admin.php?page=fluent_forms&route=entries&form_id=' . $fluentFormFormId);
                }
            } else if ($dataSourceType == 'csv' || $dataSourceType == 'google-csv') {
                $table->remoteURL = get_post_meta($table->ID, '_ninja_tables_data_provider_url', true);
            }
        }
    
        $tables = apply_filters('ninja_tables_get_all_tables', $tables);
    
        $total = wp_count_posts('ninja-table');
        $total = intval($total->publish);
        $lastPage = ceil($total / $perPage);
    
        wp_send_json_success($tables, 200);
        wp_die();
    }
    public function getNinjaTablesColumn(){
        if (function_exists('ninja_table_get_table_columns')) {
            $data = ninja_table_get_table_columns($_REQUEST['ninja_table_id']);
            wp_send_json_success($data, 200);
            wp_die();
           
        }else{
            wp_send_json_error('No data', 200);
        }
    }
    
    public function getNinjaTableData()
    {
          if (function_exists('ninja_table_get_table_columns')) {
              $id      = $_REQUEST['data']['tableId'];
              $limit   = $_REQUEST['data']['limit'];
              $columns = $_REQUEST['data']['columnData'];
              if(!$id || !$columns){
                  wp_send_json_error('No Id and Column', 200);
    
              }
            
//              ($tableId, $defaultSorting = false, $disableCache = false, $limit = false, $skip = false, $ownOnly = false)

              $data =  ninjaTablesGetTablesDataByID($id,'','',$limit);
              $formattedEntries = [];
    
              $formattedColumn  =  array_map(function($c){
                  return strtolower(str_replace(' ', '', $c));
              }, $columns);
        
              foreach ($data as $key => $value) {
                  // Prepare the entry with the selected columns.
                  
                  $temp = [];

                  foreach ($formattedColumn as $c){
                        $temp[$c] = $value[$c];
                  }
    
                  $formattedEntries[] = array(
                      'id' => $key,
                      'values' => $temp
                  );
                
              }
              wp_send_json_success($formattedEntries, 200);
              return;
          }else{
              wp_send_json_error('Ninja Table Not Found', 200);
          }
    
    }
    
    public function getNewGridKey()
    {
        global $wpdb;
    
        $table_name = $wpdb->prefix . 'pluginone_cards';
        $data = $wpdb->get_row("SELECT id FROM $table_name  ORDER BY id DESC LIMIT 1 ");
        if(empty($data)){
            $data['id'] =1;
        }
        wp_send_json_success( $data, 200);
    }
    
    public function updateCard()
    {
        $posdtData = $_REQUEST['data'];

        $insertData = wp_unslash($posdtData);
        $insertData = json_decode($insertData,true);
        
//        echo '<pre>';
//        print_r($insertData);exit;
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'pluginone_cards';
     
        try {
            if (isset($_REQUEST['remove'])&&!empty($_REQUEST['remove'])) {
               
                $success= $wpdb->delete(
                    $table_name,
                    array(
                        'id' => intval($_REQUEST['remove']),
                    )
                   
                );
    
                if(!$success){
                    throw new Exception($wpdb->last_error);
                }
                wp_send_json_success(array(
                    'response' => 'success',
    
                ), 200);
            }
            else if (isset($insertData['id'])&&!empty($insertData['id'])) {
                $success= $wpdb->update(
                    $table_name,
                    array(
                        'card_name'     => sanitize_text_field ( $insertData['grid_name'] ),
                        "user_id"       => get_current_user_id (),
                        "basicSettings" => json_encode ( $insertData ),
                        "updated_at"    => current_time ( 'mysql', get_option ( 'gmt_offset' ) ),
                        "deleted"       => 0
                    ),
                    array('id' => $insertData['id'])
                );
                
                if(!$success){
                    throw new Exception('Error !');
                }
                wp_send_json_success(array(
                    'response' => 'success',
    
                ), 200);
            } else {
                
                
                $success = $wpdb->insert(
                    $table_name,
                    array(
                        'card_name'     => sanitize_text_field ( $insertData['grid_name'] ),
                        "user_id"       => get_current_user_id (),
                        "basicSettings" => json_encode ( $insertData ),
                        "created_at"    => current_time ( 'mysql', get_option ( 'gmt_offset' ) ),
                        "updated_at"    => current_time ( 'mysql', get_option ( 'gmt_offset' ) ),
                        "deleted"       => 0
                    )
                );
    
              
          
                if(!$success){
                    throw new \Exception($wpdb->last_error);
                }
                wp_send_json_success(array(
                    'response' => 'success',
                    'insert_id' => $wpdb->insert_id

            ), 200);
            
            }
        }
        
        catch (\Exception $ex) {
            wp_send_json_error(array(
                'response' => $ex->getMessage(),
            ), 200);
     
        }
        
        
    }
    
    public function getCardDataById()
    {
       
        $id = $_REQUEST['id'];
        
        $data =  new \PluginRunTwo\Base\GridCreator\CardDataHandler;
        $data=  $data->getSingleCardData($id);
        
        
        if($data){
            wp_send_json_success($data, 200);
            return;
        }
        wp_send_json_error('No data', 200);
    
    
    
    }
}
