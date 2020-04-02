<?php


namespace PluginRunOne\Base\CardCreator;


use PluginRunOne\Base\BaseController;

class CardPreview extends BaseController
{
    public function register()
    {
        add_action('wp', array($this, 'preview'));
    }

    public function preview()
    {

        if (isset($_GET['plugin_run_one_card_card_preview']) && $_GET['plugin_run_one_card_card_preview'] != '') {
            $id = $_GET['plugin_run_one_card_card_preview'];

            $renderObj = new \PluginRunOne\Base\CardCreator\Render();
            if ($renderObj->getFrontEndSetting($id)) {

                echo $this->loadView('templates/card-preview', $id);
                exit;

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

    public function loadView($path, $id)
    {
        if (file_exists($this->plugin_path . '/' . $path . '.php')) {
            ob_start();
            //      card html
            include_once("$this->plugin_path$path.php");
            $content = ob_get_clean();

            ob_clean();
            return $content;
        }
    }

}