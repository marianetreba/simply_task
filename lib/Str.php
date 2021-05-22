<?php

class Str
{

    public static function unique($len)
    {
        return substr(sha1(uniqid() . random_int(PHP_INT_MIN, PHP_INT_MAX)), -$len); # works up to 40 characters
    }

    public static function clean($str, array $options = [])
    {
        if (!mb_check_encoding($str, 'UTF-8')) {
            return false;
        }

        $str = trim(preg_replace('/\p{Zs}+/u', ' ', $str));

        if ($options['preserve_lf']) {
            $str = preg_replace('/\n{3,}/', "\n\n", $str);
        }

        return $str;
    }

    public static function htmlSpecialChars($string)
    {
        return htmlspecialchars($string, ENT_HTML5 | ENT_QUOTES);
    }

}
