<div class="wrap">
    <h1>Custom Post Type Manager</h1>

    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="<?php echo empty($_POST)? 'active': '' ?>"><a href="#tab-1">Your Custom Post Types</a></li>
        <!--                check if edit post page from post input-->

        <li class="<?php echo  isset($_POST['edit_post'])? 'active': '' ?>">
            <a href="#tab-2">
                <?php echo isset($_POST['edit_post'])? 'Edit': 'Add' ?>  Custom Post Types
            </a></li>

        <!--                check if export post page from post input-->

        <li class="<?php echo  isset($_POST['export_post'])? 'active': '' ?>">
            <a href="#tab-3">Export</a>
        </li>
    </ul>
     <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo empty($_POST)? 'active': '' ?>">
            <h3>Manage your CPT</h3>
            <table class="widefat fixed" cellspacing="0">
                <thead>
                <tr>

                    <th  class="manage-column column-cb " scope="col">ID</th>
                    <th  class="manage-column column-columnname" scope="col">Singular Name</th>
                    <th  class="manage-column column-columnname " scope="col">Plural Name</th>
                    <th class="manage-column column-columnname " scope="col">Public</th>
                    <th  class="manage-column column-columnname " scope="col">Archive</th>
                    <th  class="manage-column column-columnname " scope="col">Action</th>

                </tr>
                </thead>
            <?php
            $options = get_option('ninja_plugin_one_cpt_option');

            if (!empty($options)){

                $i = 0;
                foreach ($options as $option) {

                    $public = isset($option['public']) ? "TRUE" : "FALSE";
                    $has_archive = isset($option['has_archive']) ? "TRUE" : "FALSE";

                    echo'<tr class="'.($i%2==0 ? 'alternate': '').'">'.
                        '<th class="check-column" scope="row">'.$option['post_type'].'</th>'.
                        '<td class="column-columnname">'.$option['singular_name'].'</td>'.
                        '<td class="column-columnname">'.$option['plural_name'].'</td>'.
                        '<td class="column-columnname">'.$public.'</td>'.
                        '<td class="column-columnname">'.$has_archive.'</td>'.
                        '<td class="column-columnname">';

                        echo  '<form method="post" action="" class="inline-block">';
                        echo '<input type="hidden" name="edit_post" value="'.$option['post_type'].'">';
                        submit_button('Edit', 'primary small', 'submit',false);
                        echo  '</form> ';


                        echo  '<form method="post" action="options.php" class="inline-block">';
                           echo '<input type="hidden" name="remove" value="'.$option['post_type'].'">';
                                settings_fields('ninja_plugin_one_cpt_settings'); //option_group from setttings
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

        <div id="tab-2" class="tab-pane <?php echo isset($_POST['edit_post'])? 'active': '' ?>">
            <h3>Add New CPT</h3>
            <form method="post" action="options.php">
                <?php
                settings_fields('ninja_plugin_one_cpt_settings'); //option_group from setttings
                do_settings_sections('ninja_plugin_one_cpt'); //page slug
                submit_button();
                ?>
            </form>
        </div>

        <div id="tab-3" class="tab-pane <?php echo  isset($_POST['export_post'])? 'active': '' ?>"">
            <h3>Exports</h3>
            <p>Select Post Type</p>
              <form method="post" action="" class="inline-block">
                  <select name="export_post" id="">
                    <?php
                    if (!empty($options)){

                    $i = 0;
                    foreach ($options as $option) {
                        echo '<option value="'.$option['post_type'].'">'. $option['singular_name'].'</option>';
                        }
                    }
                    ?>

                  </select>
                 <?php submit_button('Submit', 'primary ', 'submit',false); ?>
              </form>
            <?php  if (isset($_POST['export_post'])){
                $cpt_data = $options[$_POST['export_post']];
                $cpt_key = $cpt_data['post_type'];
                ?>

                <pre class="prettyprint">
<strong>// custom post type :<?php echo $cpt_data['post_type']?></strong>
// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Post Types', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( '<?php echo $cpt_data['singular_name']?>', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( '<?php echo $cpt_data['plural_name']?>', 'text_domain' ),
		'name_admin_bar'        => __( '<?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'archives'              => __( '<?php echo $cpt_data['singular_name']?> Archives', 'text_domain' ),
		'attributes'            => __( '<?php echo $cpt_data['singular_name']?> Attributes', 'text_domain' ),
		'parent_item_colon'     => __( '<?php echo $cpt_data['singular_name']?> Item:', 'text_domain' ),
		'all_items'             => __( 'All <?php echo $cpt_data['plural_name']?>', 'text_domain' ),
		'add_new_item'          => __( 'Add New <?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New <?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'edit_item'             => __( 'Edit <?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'update_item'           => __( 'Update <?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'view_item'             => __( 'View <?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'view_items'            => __( 'View <?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'search_items'          => __( 'Search <?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into <?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this <?php echo $cpt_data['singular_name']?>', 'text_domain' ),
		'items_list'            => __( '<?php echo $cpt_data['plural_name']?> list', 'text_domain' ),
		'items_list_navigation' => __( '<?php echo $cpt_data['plural_name']?> list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter <?php echo $cpt_data['plural_name']?> list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( '<?php echo $cpt_data['plural_name']?>', 'text_domain' ),
		'description'           => __( '<?php echo $cpt_data['plural_name']?> Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => false,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => <?php isset($cpt_data['public'])? 'true': 'false' ?>,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => <?php isset($cpt_data['has_archive'])? 'true': 'false' ?>,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( '<?php echo $cpt_data['post_type']?>', $args );

}
add_action( 'init', 'custom_post_type', 0 );
             </pre>
                <?php

            } ?>

        </div>

    </div>
</div>
