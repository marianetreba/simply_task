<?php

class Request
{

    public static function process()
    {
        $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $routes = require ROOT_DIR . '/routes.php';

        foreach ($routes as $p => $r) {
            list($methods, $pattern) = explode(' ', $p, 2);
            $methods = explode(',', $methods);
            if (!in_array(self::method(), $methods)) {
                continue;
            }
            if (preg_match('#^' . $pattern . '$#', $url_path)) {
                $route = preg_replace('#' . $pattern . '#', $r, $url_path);
                $url_query = parse_url($route, PHP_URL_QUERY);
                if ($url_query) {
                    $route = parse_url($route, PHP_URL_PATH);
                    parse_str($url_query, $params);
                    $_GET = array_merge($_GET, $params);
                }
                break;
            }
        }
        if (!$route) {
            $route = substr($url_path, 1);
        }
        list($module, $action) = explode('/', $route, 2);
        Response::forward_404_unless(preg_match('/^[a-z0-9_]*$/', $module . $action));
        define('MODULE', $module ?: 'default');
        define('ACTION', $action ?: 'index');

        User::init();

        $action_file = ROOT_DIR . '/modules/' . MODULE . '/actions/' . ACTION . '.php';
        if (is_file($action_file)) {
            spl_autoload_register(
                function ($class_name) {
                    $path = ROOT_DIR . '/modules/' . MODULE . '/models/' . $class_name . '.php';
                    if (is_file($path)) {
                        require_once $path;
                    }
                }
            );

            View::setTemplate(MODULE . '/' . ACTION);
            require $action_file;
        } else {
            Response::forward_404();
        }

        ob_start();
        include View::$template;
        $content = ob_get_clean();

        ob_start();
        require ROOT_DIR . '/templates/' . View::$layout . '.layout.php';
        $response = ob_get_clean();

        echo $response;
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isMethod($method)
    {
        return $_SERVER['REQUEST_METHOD'] == $method;
    }

}
