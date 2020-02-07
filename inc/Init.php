<?php


/**
 * @package pluginRunOne 
 */

namespace PluginRunOne;

final class Init 
{	
    /*
	* Store all the classes inside an array
	* @return all full list of classes
    */
	public static function get_services(){

		return [
			Pages\Admin::class,
			Base\Enque::class,
			// Base\SettingsLink::class
		];

	}


	/*
	* Loop through all the classes and initialize and call the register method if exists
	* @return 
    */


	public static function  register_services(){

		foreach ( self::get_services() as $class) {

			$service = self::instantiate ($class);
			if(method_exists($service, 'register')){
				$service->register();
			}
		}

	}


	/*
	* Initialize the class
	* @params class $class class from the services array
	* @return class instance new instance of the class
    */

	private static function instantiate( $class){


		$service = new $class();

		return $service;

	}
	
}




// if (!class_exists('PluginRunOne')) {

// class PluginRunOne {


// 	public $plugin;

// 	function __construct() {
// 		$this->plugin = plugin_basename( __FILE__ );

// 		$this->create_post_type();
// 	}



// 	protected function create_post_type() {

// 		add_action( 'init', array( $this, 'custom_post_type' ) );
// 	}

// 	function custom_post_type() {

// 		register_post_type( 'test-new', ['public' => true, 'label' => 'New Test'] );
// 	}

// 	public function register(){
		
// 		// enque scripts
// 		add_action( 'admin_enqueue_scripts', array($this, 'enque') );

// 		// admin menu
// 		add_action( 'admin_menu',array($this, 'add_admin_pages') );

// 		// settings link
// 		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );

// 	}

// 	public function settings_link( $links ) {

// 		$settings_link = '<a href="admin.php?page=plugin_one">Settings</a>';
// 		array_push( $links, $settings_link );
// 		return $links;
// 	}


// 	function add_admin_pages(){

// 	}

// 	function admin_index(){
		
// 		require_once plugin_dir_path( __FILE__ ).'templates/admin.php';

// 	}

// 	/**
// 	 * Method run on plugin activation
// 	 */
// 	function activate() {
		
		
// 		ActivatePlugin::activate();
// 		flush_rewrite_rules();
	
// 	}


// 	/**
// 	 * Method run on plugin dectivation
// 	 */
// 	function dectivate() {
		
// 		DeactivatePlugin::deactivate();
// 		flush_rewrite_rules();
		
	
// 	}

// 	function enque(){

// 		wp_enqueue_style( 'plugin-run-on', plugins_url( 'assets/app.css', __FILE__ ) );
// 		// wp_enqueue_script( 'plugin-run-on', plugins_url( 'assets/run-one-style.css', __FILE__ ) );
// 	}

// 	public function ticket_data(){
	
		
// 		global $wpdb;
// 		$sql = $wpdb->prepare(
// 			"SELECT ID,post_title,post_name,post_date FROM wp_posts WHERE post_type = 'ticket' ",  
// 			'ticket'
// 		);
		
// 		$results = $wpdb->get_results( $sql );
// 		$data = json_encode($results);
// 		wp_send_json( 
// 			$results
// 		);

// 		wp_die(); // this is required to terminate immediately and return a proper response

// 	}

	


// }

// /**
//  * main function
//  */

	
// 	$pluginRunOne = new PluginRunOne();
// 	$pluginRunOne->register();



// // activation
// // require_once plugin_dir_path( __FILE__ ).'src/activate.php';
// register_activation_hook( __FILE__, array( $pluginRunOne, 'activate' ) );


// // deactivation
// register_deactivation_hook( __FILE__, array( $pluginRunOne, 'deactivate' ) );

// }
