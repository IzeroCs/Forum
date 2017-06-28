<?php

    namespace Lib;

    final class Environment
    {

        private static $instance;

        private $array;
        private $cache;

        protected function __construct(array $array)
        {
            $this->array = $array;
            $this->cache = array();
        }

        public static function getInstance($array = null)
        {
            if (null === self::$instance) {
                if (null === $array)
                    trigger_error('Error array environment');

                self::$instance = new Environment($array);
            }

            return self::$instance;
        }

        public function get($name, $default = null)
        {
            if (preg_match('/^(SERVER|POST|GET|REQUEST|GLOBALS|COOKIE|SESSION)(\.(.*?))?$/s', $name, $matches)) {
                if ($matches[1] != 'GLOBALS')
                    $matches[1] = '_' . $matches[1];

                if (count($matches) <= 2) {
                    if (isset($GLOBALS[$matches[1]]))
                        return $GLOBALS[$matches[1]];

                    return null;
                }

                if (isset($GLOBALS[$matches[1]]) == false)
                    return null;

                return $this->resolve($matches[3], $default, $GLOBALS[$matches[1]]);
            }

            if (array_key_exists($name, $this->cache))
                return $this->cache[$name];

            return ($this->cache[$name] = urlSeparatorMatches($this->resolve($name, $default)));
        }

        private function resolve($key, $default = null, $array = null)
        {
            if (is_string($key) && empty($key) == false) {
                if ($array == null)
                    $array = $this->array;

                $keys  = explode('.', $key);

                if (is_array($keys) == false)
                    $keys = array($key);

                foreach ($keys AS $entry) {
                    $entry = trim($entry);

                    if (array_key_exists($entry, $array) == false)
                        return $default;

                    $array = $array[$entry];
                }

                return $this->envMatchesString($array);
            }

            return $default;
        }

        public static function envMatchesString($str)
        {
            if (is_array($str) || preg_match('/\$\{(.+?)\}/si', $str, $matches) == false)
                return $str;

            return preg_replace_callback('/\$\{(.+?)\}/si', function($matches) {
                $result = null;

                if (isset($GLOBALS[$matches[1]]))
                    $result = $GLOBALS[$matches[1]];
                else if (defined($matches[1]))
                    $result = constant($matches[1]);
                else
                    $result = env(trim($matches[1]));

                if (is_array($result))
                    return 'Array';
                else if (is_object($result))
                    return 'Object';
                else if (is_resource($result))
                    return 'Resource';
                return $result;
            }, $str);
        }

        private function __clone()
        {

        }

        private function __wakeup()
        {

        }

    }
