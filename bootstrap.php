<?php

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', __DIR__);
}

if (file_exists(ROOT_DIR . '/vendor/autoload.php')) {
    require_once ROOT_DIR . '/vendor/autoload.php';
}

spl_autoload_register(
    function ($class_name) {
        $paths = [
            ROOT_DIR . '/lib/' . $class_name . '.php',
            ROOT_DIR . '/lib/base/' . $class_name . '.php'
        ];
        foreach ($paths as $path) {
            if (is_file($path)) {
                require_once $path;
            }
        }
    }
);

Config::init();

mb_internal_encoding('UTF-8');
setlocale(LC_ALL, Config::get('locale'));
date_default_timezone_set(Config::get('timezone'));
