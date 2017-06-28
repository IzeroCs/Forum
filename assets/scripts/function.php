<?php

    function console($var)
    {
        echo('<pre>');
        var_dump($var);
        echo('</pre>');
    }

    function separator($str, $separator = SP)
    {
        $str = str_replace('/',  $separator, $str);
        $str = str_replace('//', $separator, $str);

        return $str;
    }

    function env($name, $default = null)
    {
        return Lib\EnvironmentFactory::get($name, $default);
    }

    function lng($name)
    {
        $params = null;

        if (is_array($params) == false) {
            $nums = func_num_args() - 1;
            $args = func_get_args();

            if ($nums >= 1 && is_array($args[1]))
                $params = $args[1];
            else if ($nums > 0 && $nums % 2 == 0)
                $params = array_splice($args, 1, $nums);
        }

        return Lib\LanguageFactory::get($name, $params);
    }

    function lngToJson()
    {
        if (is_array($load) == false) {
            $load = array();
            $nums = func_num_args();

            if ($nums > 0)
                $load = func_get_args();
        }

        return Lib\LanguageFactory::lngToJson($load);
    }

    function urlSeparatorMatches($str)
    {
        return separator($str, HTTP_SEPARATOR);
    }
