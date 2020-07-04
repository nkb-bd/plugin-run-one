<?php
defined('ABSPATH') or die;

// for laravel dd pkg
//require_once __DIR__ . '/vendor/autoload.php';


spl_autoload_register(function ($class) {
    $namespace = 'PluginRunTwo';
    if (substr($class, 0, strlen($namespace)) !== $namespace) {
        return;
    }

    $className = str_replace(
        array('\\', $namespace, strtolower($namespace)),
        array('/', 'inc', ''),
        $class
    );

    $basePath = plugin_dir_path(__FILE__);

    $file = $basePath.trim($className, '/').'.php';

    if (is_readable($file)) {
        include $file;
    }
});
