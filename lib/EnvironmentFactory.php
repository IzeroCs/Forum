<?php

    namespace Lib;

    final class EnvironmentFactory
    {

        public static function get($name, $default = null)
        {
            return Environment::getInstance()->get($name, $default);
        }

    }

?>