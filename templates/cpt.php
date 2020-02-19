<div class="wrap">
    <h1>Custom Post Type Manager</h1>

    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Your Custom Post Types</a></li>
        <li><a href="#tab-2">Add Custom Post Types</a></li>
        <li><a href="#tab-3">Export</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <h3>Manage your CPT</h3>
            <table class="widefat fixed" cellspacing="0">
                <thead>
                <tr>

                    <th  class="manage-column column-cb " scope="col">ID</th>
                    <th  class="manage-column column-columnname" scope="col">Singular Name</th>
                    <th  class="manage-column column-columnname " scope="col">Plural Name</th>
                    <th class="manage-column column-columnname " scope="col">Public</th>
                    <th  class="manage-column column-columnname " scope="col">Archive</th>

                </tr>
                </thead>
            <?php
            $options = get_option('ninja_plugin_one_cpt_option');

            if (!empty($options)){

                $i = 0;
            foreach ($options as $option) {
                echo $option['singular_name'],'</br>';

                echo '<tr class="'.($i%2==0 ? 'alternate': '').'"><th class="check-column" scope="row">'.$option['singular_name'].'</th><td class="column-columnname">'.$option['singular_name'].'</td><td class="column-columnname">'.$option['plural_name'].'</td><td class="column-columnname">'.$option['public'].'</td><td class="column-columnname">'.$option['has_archive'].'</td></tr>';
                $i++;

            }
            }
            ?>

                </tbody>
            </table>
        </div>

        <div id="tab-2" class="tab-pane">
            <h3>Add New CPT</h3>
            <form method="post" action="options.php">
                <?php
                settings_fields('ninja_plugin_one_cpt_settings'); //option_group from setttings
                do_settings_sections('ninja_plugin_one_cpt'); //page slug
                submit_button();
                ?>
            </form>
        </div>

        <div id="tab-3" class="tab-pane">
            <h3>Export</h3>
        </div>
    </div>
</div>
