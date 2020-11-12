<?php

/**
 * @package plugin run one
 */


namespace PluginRunTwo\Base;

class ActivatePlugin  extends BaseController
{

	public function activate()
	{
		$this->flush();
		$this->createTables();
        $default = array();
        if ( ! get_option( 'ninja_plugin_one_cpt_option' ) ) {
            update_option( 'ninja_plugin_one_cpt_option', $default );
        }
	}
	public  function flush()
	{
		flush_rewrite_rules();
	}

    //db operation
    private  function createTables()
    {
        //        create card table
        $this->createCardTable();
        //       check database version
        if( !get_option( $this->plugin_prefix.'db_version')) {

            update_option($this->plugin_prefix.'db_version', $this->database_version, false);

        } else {
        // else force table upgrade
            if(get_option($this->plugin_prefix.'db_version') < $this->database_version) {
                // We need to upgrade the database
                $this->forceUpgradeDB();
                update_option($this->plugin_prefix.'db_version', $this->database_version, false);

            }

        }

    }
    public function forceUpgradeDB()
    {
        //force upgrade
        $this->createCardTable(true);

    }


    private  function createCardTable($forced = false)
    {
        // card table
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'pluginone_cards';
        $sql = "CREATE TABLE ".$table_name." (
                                          `id` int(21) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                          `user_id` int(10) NULL,
                                          `card_name` varchar(255)  NULL,
                                          `basicSettings` varchar(1000)  NULL,
                                          `created_at` timestamp  NULL,
                                          `updated_at` timestamp  NULL,
                                          `deleted` boolean not null default 0
                                        ) $charset_collate;";

        if($forced) {
            return $this->runForceSQL($sql, $table_name);
        }
        return $this->runSQL($sql, $table_name);
    }

    private function runSQL($sql, $tableName)
    {

        global $wpdb;
        if ($wpdb->get_var("SHOW TABLES LIKE '".$tableName."'") != $tableName) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    private function runForceSQL($sql, $tableName)
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        return true;
    }



}
