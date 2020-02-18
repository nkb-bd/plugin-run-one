<div class="wrap">
    <h1>Custom Post Type</h1>

    <?php settings_errors(); ?>

            <form method="post" action="options.php">
                <?php
                settings_fields('ninja_plugin_one_cpt_settings'); //option_group from setttings
                do_settings_sections('ninja_plugin_one_cpt'); //page slug
                submit_button();
                ?>
            </form>


</div>
