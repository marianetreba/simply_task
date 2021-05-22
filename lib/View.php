<?php

class View
{
    public static string $layout = 'default';
    public static $template = null;
    public static $title = null;

    public static function getTitle()
    {
        return self::$title ?: Config::get('site_name');
    }

    public static function setTemplate($template)
    {
        self::$template = self::getTemplatePath($template);
    }

    private static function getTemplatePath($template)
    {
        if (strstr($template, '/')) {
            list($module, $template) = explode('/', $template);
        } else {
            $module = MODULE;
        }
        return ROOT_DIR . '/modules/' . $module . '/templates/' . $template . '.php';
    }


    private static function getPartialPath($partial)
    {
        if (strstr($partial, '/')) {
            list($module, $partial) = explode('/', $partial);
        } else {
            $module = MODULE;
        }
        return ROOT_DIR . ($module == 'global' ? '/' : '/modules/' . $module . '/') . 'templates/_' . $partial . '.php';
    }

    public static function includePartial($partial, array $params = [])
    {
        extract($params, EXTR_SKIP);
        include self::getPartialPath($partial);
    }

}
