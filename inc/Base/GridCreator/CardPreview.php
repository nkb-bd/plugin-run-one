<?php


namespace PluginRunTwo\Base\GridCreator;



use PluginRunTwo\Base\BaseController;

class CardPreview extends BaseController
{
    public function register()
    {
        add_action('wp', array($this, 'preview'));
    }

    public function preview()
    {
    
        //styles for front end
        wp_enqueue_style(
            'plugin-run-on-style-card',
            $this->plugin_url.'assets/public/css/plugin-one-card-public.css',
            '',
            $this->version
        );

        if (isset($_GET['plugin_run_two_card_card_preview']) && $_GET['plugin_run_two_card_card_preview'] != '') {
            $id = $_GET['plugin_run_two_card_card_preview'];
            
            

            $renderObj = new \PluginRunTwo\Base\GridCreator\Render();
            if ($renderObj->getGridSettings($id)) {

                echo $this->loadView('templates/card-preview', $id);
                exit();

            } else {
                wp_redirect(home_url());
            }
        }
    }

    private function loadDefaultPageTemplate()
    {
        add_filter('template_include', function ($original) {
            return locate_template(['page.php', 'single.php', 'index.php']);
        });
    }

    /**
     * Set the posts to one
     *
     * @param WP_Query $query
     *
     * @return void
     */
    public function pre_get_posts($query)
    {
        if ($query->is_main_query()) {
            $query->set('posts_per_page', 1);
        }
    }

    public function loadView($pathToFile, $id)
    {
        if (file_exists($this->plugin_path . '/' . $pathToFile . '.php')) {
            ob_start();
            //grid html
            include_once("$this->plugin_path$pathToFile.php");
            $content = ob_get_clean();

            ob_clean();
            return $content;
        }
    }

}
