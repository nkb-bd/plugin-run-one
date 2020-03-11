<?php

/**
 * @package plugin run one 
 */


namespace PluginRunOne\Base;

class ActivatePlugin 
{
	
	public function activate()
	{	
		self::flush();
		self::migrate();

        $default = array();

        if ( ! get_option( 'ninja_plugin_one_cpt_option' ) ) {
            update_option( 'ninja_plugin_one_cpt_option', $default );
        }
	}
	public static function flush()
	{
		flush_rewrite_rules();
	}

    //db operation
    private static function migrate()
    {
        self::createCardTable();;
    }

    private static function createCardTable()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'pluginone_cards';
        $sql = "CREATE TABLE $table_name (
                                          `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                          `user_id` int(10) NULL,
                                          `card_name` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `basicSettings` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `created_at` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `deleted` boolean not null default 0                                          
                                        ) $charset_collate;";

        self::runSQL($sql, $table_name);
    }

    private static function runSQL($sql, $tableName)
    {
        global $wpdb;
        if ($wpdb->get_var("SHOW TABLES LIKE '$tableName'") != $tableName) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }



}