<?php


/**
 * @package PluginRunTwo
 */

namespace PluginRunTwo;

final class Init
{
    /*
	* Store all the classes inside an array
	* @return all full list of classes
    */
	public static function get_services(){

		return [
			Base\Enque::class,
            Pages\Dashboard::class,
            Base\CustomPostTypeController::class,
            Base\TaxonomyManagerController::class,
			Base\SettingsLink::class,
			Base\GridCreatorController::class
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
	* Initialize the class loaded by register services
	* @params class $class class from the services array
	* @return class instance new instance of the class
    */

	private static function instantiate( $class){

	    if (class_exists($class)){
            return  new $class();
        }

	}

}


