<?php

// plugin unistall

if (! defined('WP_UNINSTALL_PLUGIN')) {
	die;
}
// clear database

$books = get_posts(  array('post_type' =>'bookeis' ,'numberposts' => -1 ));

foreach ($books as $book) {
  wp_delete_post( $book->ID, true );
}

// access database via sql
// global $wpdb;

// $wpdb->query("DELETE FROM wp_posts WHERE post_type = 'bookies'");
// $wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (select id from wp_posts)");
// $wpdb->query("DELETE FROM wp_term_relationships WHERE obejct_id NOT IN (select id from wp_posts)");