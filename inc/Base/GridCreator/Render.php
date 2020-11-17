<?php


/**
 * @package PluginRunTwo
 * Grid creator shortcode render
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
    public function getStylesForAdminPreview()
    {
        //styles for front end
        return file_get_contents($this->plugin_path.'assets/public/css/plugin-one-card-public.css',true);
    }

    public function renderShortcode($id)
    {
        
      
        $data = $this->getGridSettings($id);
        
        
        $this->enque();
        ob_start();
        if (!$data){
           
            //      card html
           echo '<i> No data found for this ID ! </i>';
    
            $content = ob_get_clean();
            return $content;
        }
        

      
        //grid html
        $gridTemplate = $data['grid_template'];
        
        if (!file_exists($this->plugin_path . '/templates/' . $gridTemplate . '.php')) {
            echo 'Missing Template File '. $gridTemplate . '.php';
            return;
        }
        require($this->plugin_path."templates/template-one.php");
        $content = ob_get_clean();
    
        return $content;

    }

    public function renderPreviewForAdmin($id)
    {
        $data = $this->getGridSettings($id);
        
        $gridTemplate = $data['grid_template'];
 
        ob_start();
//            $css = $this->getStylesForAdminPreview();
//            echo '<style>'.$css.'</style>';
    
        if (!file_exists($this->plugin_path . '/templates/card-preview.php')) {
           echo 'Missing Template File '. $gridTemplate . '.php';
           return;
        }
     
        include "$this->plugin_path$pathToFile.php";
    
        return ob_get_clean();

    }

    public function getGridSettings($id)
    {
        $data =  new \PluginRunTwo\Base\GridCreator\CardDataHandler ;
        
        $rednderData =  $data->getSingleCardData($id);
 
        if(!$rednderData){
            echo "<b>No data found !</b>";
            return false;
        }
  
        $basic_settings = json_decode( $rednderData->basicSettings,true);
        $settingsFormatted = [];
        $settingsFormatted['grid_source'] =  $basic_settings['grid_source'];
    
        $gridConfig['button_status'] =  $basic_settings['button_status'];
      
        $gridConfig['button_text'] =  $basic_settings['button_text'];
        $settingsFormatted['field_border'] =  isset($basic_settings['field_border']) ? $basic_settings['field_border']: '' ;
        $settingsFormatted['borderColor'] =  isset($basic_settings['borderColor'])?$basic_settings['borderColor']:'';
        
    
        switch ( $settingsFormatted['grid_source']) {
           
            case 'post':
                $gridConfig['postType'] =  $basic_settings['postType'];
                $gridConfig['category'] =  $basic_settings['category'];
                $gridConfig['content_limit'] =  isset($basic_settings['content_limit'])? $basic_settings['content_limit']:30;
                $gridConfig['limit'] =  $basic_settings['limit'];
                
                
                $settingsFormatted['gridItems'] =  $this->getPostGridItems(  $gridConfig );
                
                break;
            case 'ninja_table':
               
                $gridConfig['ninjaTableData'] = $basic_settings['ninjaTableData'];
                $gridConfig['formattedFieldList'] =  $basic_settings['formattedFieldList'];
    
                $gridConfig['limit'] = $basic_settings['limit'];
                $gridConfig['title'] = $basic_settings['title'];
                $gridConfig['title_status'] = $basic_settings['title_status'];
                $gridConfig['content'] = $basic_settings['content'];
                $gridConfig['content_status'] = $basic_settings['content_status'];
                $gridConfig['img'] =  $basic_settings['img'];
                $gridConfig['img_status'] =  $basic_settings['img_status'];
                $gridConfig['button_link'] =  $basic_settings['button_link'];
    
                $settingsFormatted['gridItems'] =  $this->getNinjaTabletGridItems( $gridConfig );
                
                break;
                
            case 'fluent_form':
                $gridConfig['fluentFormData'] = $basic_settings['fluentFormData'];
                $gridConfig['formattedFieldList'] = $basic_settings['formattedFieldList'];
    
                $gridConfig['limit'] = $basic_settings['limit'];
                $gridConfig['title'] = $basic_settings['title'];
                $gridConfig['title_status'] = $basic_settings['title_status'];
                $gridConfig['content'] = $basic_settings['content'];
                $gridConfig['content_status'] = $basic_settings['content_status'];
                $gridConfig['img'] =  $basic_settings['img'];
                $gridConfig['img_status'] =  $basic_settings['img_status'];
                $gridConfig['button_link'] =  $basic_settings['button_link'];
                $gridConfig['formattedFieldList'] =  $basic_settings['formattedFieldList'];
                $settingsFormatted['gridItems'] =  $this->getFluentFormGridItems( $gridConfig );
    
    
    
                break;
            
        }
     
        //task later move theme inside postData array
        $settingsFormatted['grid_name'] =  $basic_settings['grid_name'];
      
        $settingsFormatted['img_status'] =  $basic_settings['img_status'];
        
        $settingsFormatted['grid_template'] =  isset($basic_settings['grid_template'])?$basic_settings['grid_template'] : 'template-one';
    
        //task later move theme inside contentData array
        $settingsFormatted['columnNumber'] =  $basic_settings['columnNumber'];
        $settingsFormatted['columnNumber'] =  $basic_settings['columnNumber'];
        $settingsFormatted['img_status'] =  $basic_settings['img_status'];
        $settingsFormatted['view'] =  $basic_settings['view'];
        $settingsFormatted['limit'] =  $basic_settings['limit'];
        
        //task later move theme inside styleData array
        $settingsFormatted['bgColor'] =  $basic_settings['bgColor'];
        $settingsFormatted['fontColor'] =  $basic_settings['fontColor'];
        $settingsFormatted['fontColor'] =  $basic_settings['fontColor'];
        $settingsFormatted['content_align'] =  $basic_settings['content_align'];
        $settingsFormatted['item_border_radius'] =  $basic_settings['item_border_radius'];
        $settingsFormatted['button_text'] =  $basic_settings['button_text'];
        $settingsFormatted['button_newtab'] =  $basic_settings['button_newtab'];
        $settingsFormatted['button_status'] =  $basic_settings['button_status'];
        
     
        return $settingsFormatted;

    }
    
    public function getPostGridItems($data)
    {
        $args =  array(
            'post_type'      => $data['postType'],
            'cat'            => $data['category'],
            'post_status'    => 'publish',
            'orderby'        => 'ID',
            'posts_per_page' => $data['limit']
        );
    
        $posts = new \WP_Query( $args );
        $postArray = [];
        foreach ($posts->posts as $post){
            
            if($avatar = get_avatar_url(get_the_author_meta($post->post_author)) ){
                $avatar = $avatar ;
            }else{
                $avatar = ' https://secure.gravatar.com/avatar/1e01ea5e304a25eaec5bec5560e619a7?s=64&d=mm&r=g' ;
            }
            $img_url = (get_the_post_thumbnail_url ( $post -> ID, 'post-thumbnail' ))? get_the_post_thumbnail_url ( $post -> ID, 'post-thumbnail' ): $this->plugin_url.'assets/public/blank.png';
            $content =  wp_trim_words ($post->post_content, $data['content_limit'], '...' );
        
            $postArray[] = [
                'title'         => wp_trim_words($post -> post_title, 40, '...') ,
                'content'       => do_shortcode($content),
                'date'          => get_the_date ( '', $post -> ID ),
                'author'        => get_the_author_meta ( 'user_nicename', $post -> post_author ),
                'author_link'   => get_the_author_meta ( 'user_url', $post -> post_author ),
                'author_avatar' => $avatar,
                'img'           => $img_url,
                'item_link'     => get_permalink ( $post -> ID ),
                'button_text'     => $data['button_status'] === true ? $data['button_text'] : '',
            ];
        }
        wp_reset_postdata();
        return $postArray;
    }
    
    public function getNinjaTabletGridItems($config)
    {
        if (function_exists('ninja_table_get_table_columns')) {
           
            $id =  $config['ninjaTableData']['tableId'];
            $limit =  $config['limit'];
            $columns =  $config['ninjaTableData']['columnData'];
            $tempItems= [];
            $tempFieldItems= [];
            if(!$id || !$columns){
                return [];
            }
            // for later
            // ($tableId, $defaultSorting = false, $disableCache = false, $limit = false, $skip = false, $ownOnly = false)
        
            $data =  ninjaTablesGetTablesDataByID($id,'','',$limit);
            $formattedEntries = $tempFieldItems =[];
            foreach ($data as $key => $value) {
                // Prepare the entry with the selected columns.
                $title = $config['title_status'] === true ? $value[$config['title']]: '';
                $content = $config['content_status'] === true ? $value[$config['content']]:'';
                $img = $config['img_status'] === true ? $value[$config['img']]:'';
                $link = isset( $value[$config['button_link']]) && $config['button_status'] === true ? $value[$config['button_link']]:'';
              
                if(isset($config['formattedFieldList'])){
                    foreach ($config['formattedFieldList'] as $field){
                        if( $field['status'] === true && isset($value[$field['key']])){
                            $tempFieldItems[$field['key']]= [
                                'value'=>$value[$field['key']],
                                'label'=>$field['label'],
                            ];
                        }
                    }
                }
               
    
                $formattedEntries[] = [
                    'title'=>$title,
                    'content'=>$content,
                    'img'=>$img,
                    'item_link'=>$link,
                    'formattedFields'=>$tempFieldItems
                ];
              
            }
        
            return  $formattedEntries ;
        }else{
            return [];
        }
    }
    
    public function getFluentFormGridItems($config)
    {
        if (function_exists('wpFluentForm')) {
    
            $id =  $config['fluentFormData']['formId'];
            $limit =  $config['limit'];
            $fields =  $config['fluentFormData']['fieldData'];
        
            
            $entries = wpFluentForm('FluentForm\App\Modules\Entries\Entries')->_getEntries(
                intval($id),
                isset($_GET['page']) ? intval($_GET['page']) : 1,
                intval($limit),
                'DESC',
                'all',
                null
            );
        
            $formattedEntries = $tempFieldItems =[];
            
            
            foreach ($entries['submissions']['data'] as $key => $value) {
                $value = $value->user_inputs = $this->prepareEntry($value, $fields);
                // Prepare the entry with the selected columns.
                
                $title = $config['title_status'] === true ?  $value[$config['title']]: '';
                $content = $config['content_status'] === true ? $value[$config['content']]:'';
                $img = $config['img_status'] === true ? $value[$config['img']]:'';
                $link = ($config['button_status'] === true) ? $value[$config['button_link']]:'';
        
                foreach ($config['formattedFieldList'] as $field){
                    if( $field['status'] === true){
                        $tempFieldItems[$field['key']]= [
                            'value'=>$value[$field['key']],
                            'label'=>$field['label'],
                        ];
                    }
                }
                
                $formattedEntries[] = [
                    'title'=>$title,
                    'content'=>$content,
                    'img'=>$img,
                    'item_link'=>$link,
                    'formattedFields'=>$tempFieldItems
                ];
           
                
        
            }
           
            return  $formattedEntries;
        
        }
    
        return [];
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
}
