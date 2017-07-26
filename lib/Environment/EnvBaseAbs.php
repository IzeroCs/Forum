<?php

    namespace Lib\Environment;

    abstract class EnvBaseAbs
    {

        protected function __construct()
        {

        }

        public static function processParams($params)
        {
            $arrays = explode(',', $params);
            $arrays = array_map('trim', $arrays);

            return $arrays;
        }

        protected abstract function invoke($params, $strDefault = null);

    }
