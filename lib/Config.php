<?php

class Config
{

    private static $params;
    private static $cache;

    public static function init()
    {
        self::$params = require ROOT_DIR . '/config.php';
        self::$cache = [];
    }

    public static function get($key)
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $value = self::$params;
        $path = explode('.', $key);
        while ($k = array_shift($path)) {
            $value = $value[$k];
        }

        self::$cache[$key] = $value;

        return $value;
    }
}
