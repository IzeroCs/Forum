<?php

    namespace Lib;

    final class LanguageFactory
    {

        public static function get($name, $params = [])
        {
            return Language::getInstance()->get($name, $params);
        }

        public static function lngToJson($args = null)
        {
            return Language::getInstance()->lngToJson($args);
        }

    }
