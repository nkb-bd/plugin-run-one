
    <?php

    $option = get_option( 'ninja_plugin_one_cpt_option' );


        $cpt_data = $option[$key];
        

        ?>
// custom post type :<?php echo $cpt_data['post_type']?>
// Register Custom Post Type

function custom_post_type() {

	$labels = array(
		'name'                  => _x( '<?php echo $cpt_data['singular_name']?>', 'Post Type General Name', 'text_domain' ),
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




