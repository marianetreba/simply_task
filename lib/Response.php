<?php

class Response
{

    public static function redirect($url, $status = 302)
    {
        if ($url[0] != '/') {
            if ($url == 'return') {
                $url = $_SESSION['return_url'];
                unset($_SESSION['return_url']);
            } elseif ($url == 'back') {
                if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) == $_SERVER['HTTP_HOST']) {
                    $url = $_SERVER['HTTP_REFERER'];
                } else {
                    $url = '//' . $_SERVER['HTTP_HOST'] . '/';
                }
            }
            $url = $url ?: '/';
        }

        $status_msgs = [301 => 'Moved Permanently', 302 => 'Found'];
        header('Status: ' . $status . ' ' . $status_msgs[$status]);
        header('Location: ' . $url);

        die;
    }

    public static function redirect_if($cond, $url = null, $status = 302)
    {
        if ($cond) {
            self::redirect($url, $status);
        }
    }

    public static function forward_404()
    {
        header('Status: 404 Not Found');
        View::setTemplate('default/not_found');
        ob_start();
        include View::$template;
        $content = ob_get_clean();
        require ROOT_DIR . '/templates/' . View::$layout . '.layout.php';
        die;
    }

    public static function forward_404_unless($cond)
    {
        if (!$cond) {
            self::forward_404();
        }
    }

    public static function send_json($data)
    {
        header('Content-Type: application/json;charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS);
        die;
    }
}
