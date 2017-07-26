<?php

    use Lib\Forward as ForwardParent;

    final class Forward
    {

        public static function request($pattern, $action, $method = REQUEST_METHOD_GET)
        {
            return ForwardParent::request($pattern, $action, $method);
        }

    }

?>