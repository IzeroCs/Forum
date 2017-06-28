<?php

    namespace Lib;

    final class Language
    {

        private static $instance;
        private static $params;

        private $containerPath;
        private $mimeLang;
        private $localeLang;
        private $localDefault;
        private $splitTag;

        private $lang;
        private $cache;

        const SPLIT_TAG = '.';

        protected function __construct()
        {
            $this->lang = array();
            $this->cache = array();

            $this->containerPath = env('language.path');
            $this->mimeLang      = env('language.mime');
            $this->localeLang    = env('language.locale.user',    'en');
            $this->localDefault  = env('language.locale.default', 'en');
            $this->splitTag      = env('language.split_tag',      self::SPLIT_TAG);
        }

        public static function getInstance()
        {
            if (null === self::$instance)
                self::$instance = new Language();

            return self::$instance;
        }

        public function get($name, $params = [])
        {
            if ($name == null || empty($name))
                trigger_error('Name langauge is null');

            if (preg_match('/^[a-zA-Z0-9_]+\..+?$/si', $name)) {
                if (array_key_exists($name, $this->cache))
                    return $this->cache[$name];

                $filepath   = null;
                $prefixKey  = null;
                $keyCurrent = $name;
                $array      = $this->load($name, $filepath, true, $prefixKey);

                if ($prefixKey != null)
                    $keyCurrent = substr($keyCurrent, strlen($prefixKey));

                if (strpos($keyCurrent, $this->splitTag) === 0)
                    $keyCurrent = substr($keyCurrent, 1);

                $arrayKeys = explode($this->splitTag, $keyCurrent);

                if (is_array($arrayKeys) == false)
                    return trigger_error('Key "' . $name . '" not found in language "' . $filepath . '"');

                foreach ($arrayKeys AS $entry) {
                    $entry = trim($entry);

                    if (is_array($array) == false || array_key_exists($entry, $array) == false)
                        return trigger_error('Key "' . $name . '" not found in language "' . $filepath . '"');

                    $array = $array[$entry];
                }

                if (is_array($array))
                    return ($this->instance->cache[$name] = 'Array');
                else if (is_object($array))
                    return ($this->instance->cache[$name] = 'Object');
                else if (is_resource($array))
                    return ($this->instance->cache[$name] = 'Resource');

                $array = Environment::envMatchesString($array);
                $array = Language::langMatchesString($array, $params);

                if (is_array($params) && count($params) > 0) {
                    $count = count($params);

                    if ($count % 2 == 0) {
                        for ($i = 0; $i < $count; $i += 2) {
                            $key   = $i;
                            $value = null;

                            if (isset($params[$i]))
                                $key = $params[$i];
                            if (isset($params[$i + 1]))
                                $value = $params[$i + 1];

                            $array = str_replace('{$' . $key . '}', $value, $array);
                        }

                    }
                    return $array;
                }

                return ($this->cache[$name] = $array);
            }

            return trigger_error('Key "' . $name . '" not found in language "' . $filepath . '"');
        }

        public function load($filename, &$filepath = null, $isLoadRequire = true, &$prefixKey = null)
        {
            if (strpos($filename, $this->splitTag) === false)
                return trigger_error('File name "' . $filename . '" not matches symbol "."');

            $key           = null;
            $container     = $this->containerPath;
            $mime          = $this->mimeLang;
            $locale        = $this->localeLang;
            $splitFilename = explode($this->splitTag, $filename);

            // Check array split name is array
            if (is_array($splitFilename) == false || count($splitFilename) <= 0)
                return trigger_error('File name "' . $filename . '" is wrong');

            $path = null;

            // Find path file language
            foreach ($splitFilename AS $index => $value) {
                if ($index === 0) {
                    $path = $container . SP . $locale . SP . $value;

                    // Check file in locale set of user is exists
                    if (@is_dir($path) == false) {
                        if (@is_file($path . $mime)) {
                            $path .= $mime;
                            $key   = $locale . $this->splitTag . $value;

                            break;
                        } else {
                            $locale = $this->localDefault;
                            $path   = $container . SP . $locale . SP . $value;

                            // Check file in locale default is exists
                            if (@is_dir($path) == false) {
                                if (@is_file($path . $mime) == false) {
                                    return trigger_error('File name "' . $filename . '" not found');
                                } else {
                                    $path .= $mime;
                                    $key   = $locale . $this->splitTag . $value;

                                    break;
                                }
                            } else {
                                $locale . $this->splitTag . $value;
                            }
                        }
                    } else {
                        $key = $locale . $this->splitTag . $value;
                    }
                } else if (@is_dir($path . SP . $value)) {
                    $path .= SP . $value;
                } else if (is_file($path . SP . $value . $mime)) {
                    $path .= SP . $value . $mime;
                    $key  .= $this->splitTag . $value;

                    break;
                }
            }

            $prefixKey = substr($key, strlen($locale) + 1);
            $array     = array();
            $filepath  = $path;

            if (array_key_exists($key, $this->lang))
                $array = $this->lang[$key];
            else if ($path != null && @is_file($path))
                $this->lang[$key] = ($array = require_once($path));
            else
                return trigger_error('File language "' . $filename . '" not found');

            if ($isLoadRequire && is_array($array))
                return $this->loadRequire($array);

            return $array;
        }

        private function loadRequire(array &$array)
        {
            if (is_array($array) == false)
                return $array;

            foreach ($array AS &$value) {
                if (is_array($value))
                    $this->loadRequire($value);
                else if (preg_match_all('/\#\{([a-zA-Z0-9_]+)\.(.+?)\}/si', $value, $matches))
                    $this->load($matches[1][0], $filepath, false);
            }

            return $array;
        }

        protected static function langMatchesString($str, $params)
        {
            if (is_array($str) || (preg_match('/\#\{(.+?)\}/si', $str) == false && preg_match('/lng\{(.+?)\}/si', $str, $matches) == false))
                return $str;

            self::$params = $params;

            $str = preg_replace_callback('/\#\{(.+?)\}/si', function($matches) {
                return lng(trim($matches[1]), self::$params);
            }, $str);

            $str = preg_replace_callback('/lng\{(.+?)\}/si', function($matches) {
                return lng(trim($matches[1]), self::$params);
            }, $str);

            return $str;
        }

        public function lngToJson($args = null)
        {
            if (is_array($args)) {
                foreach ($args AS $lang)
                    $this->load($lang);
            }

            return $this->toJson();
        }

        public function toJson()
        {
            return json_encode($this->lang);
        }

    }
