<div class="wrap">
    <h1>Taxonomy Manager</h1>

    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="<?php echo empty($_POST)? 'active': '' ?>"><a href="#tab-1">Your Taxonomies</a></li>
        <!--                check if edit post page from post input-->

        <li class="<?php echo  isset($_POST['edit_taxonomy'])? 'active': '' ?>">
            <a href="#tab-2">
                <?php echo isset($_POST['edit_taxonomy'])? 'Edit': 'Add' ?>  Taxonomy
            </a></li>

        <!--                check if export post page from post input-->

        <li class="<?php echo  isset($_POST['export_post'])? 'active': '' ?>">
            <a href="#tab-3">Export</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo empty($_POST)? 'active': '' ?>">
            <h3>Manage your Custom Taxonomies</h3>
            <table class="widefat fixed" cellspacing="0">
                <thead>
                <tr>

                    <th  class="manage-column column-cb " scope="col">ID</th>
                    <th  class="manage-column column-columnname" scope="col">Singular Name</th>
                    <th  class="manage-column column-columnname " scope="col">Plural Name</th>
                    <th class="manage-column column-columnname " scope="col">Public</th>
                    <th  class="manage-column column-columnname " scope="col">Action</th>

                </tr>
                </thead>
                <?php
               $options = get_option('ninja_plugin_one_tax_option');

              
               if (!empty($options)){

                   $i = 0;
                   foreach ($options as $option) {



                       $hierarchical = isset($option['hierarchical']) ? "TRUE" : "FALSE";

                       echo'<tr class="'.($i%2==0 ? 'alternate': '').'">'.
                           '<th class="check-column" scope="row">'.$option['taxonomy'].'</th>'.
                           '<td class="column-columnname">'.$option['singular_name'].'</td>'.
                           '<td class="column-columnname">'.$hierarchical.'</td>'.
                           '<td class="column-columnname">';

                       echo  '<form method="post" action="" class="inline-block">';
                       echo '<input type="hidden" name="edit_taxonomy" value="'.$option['taxonomy'].'">';
                       submit_button('Edit', 'primary small', 'submit',false);
                       echo  '</form> ';


                       echo  '<form method="post" action="options.php" class="inline-block">';
                       echo '<input type="hidden" name="remove" value="'.$option['taxonomy'].'">';
                       settings_fields('ninja_plugin_one_tax_settings'); //option_group from setttings
                       submit_button('Delete','delete danger small', 'submit',false, array(
                           'onclick' => 'return confirm("Confirm Delete ?");'
                       ));

                       echo  '</form>'.
                           '</td>'.
                           '</tr>';
                       $i++;

                   }
               }
                ?>

                </tbody>
            </table>
        </div>

        <div id="tab-2" class="tab-pane <?php echo isset($_POST['edit_taxonomy'])? 'active': '' ?>">
            <h3>Add New Taxonomies</h3>
            <form method="post" action="options.php">
                <?php
               settings_fields('ninja_plugin_one_tax_settings'); //option_group from setttings
               do_settings_sections('ninja_plugin_one_taxonomy'); //page slug
               submit_button();
                ?>
            </form>
        </div>

        <div id="tab-3" class="tab-pane <?php echo  isset($_POST['export_post'])? 'active': '' ?>"">
        <h3>Exports</h3>

    </div>

</div>
</div>
