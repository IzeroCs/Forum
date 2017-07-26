<?php

    namespace Lib\Forward;

    final class Uri
    {

        private $uri;
        private $action;
        private $method;
        private $matches;

        protected function __construct($uri, $action, $method)
        {
            $this->uri     = self::processUri($uri);
            $this->action  = $action;
            $this->method  = $method;
            $this->matches = array();
        }

        protected function __clone()
        {

        }

        protected function __wakeup()
        {

        }

        public function match($matches)
        {
            $this->matches = $matches;

            if (is_array($this->matches) == false)
                $this->matches = array();
        }

        public function equals($uriRequest, $methodRequest)
        {
            if ($this->equalsMethodRequest($methodRequest) == false)
                return false;

            if ($this->equalsUriRequest($uriRequest) == false)
                return false;

            return true;
        }

        public function equalsMethodRequest($methodRequest)
        {
            if (strcasecmp($this->method, REQUEST_METHOD_REQUEST) === 0)
                return true;

            if (strcasecmp($methodRequest, $this->method) === 0)
                return true;

            return false;
        }

        public function equalsUriRequest($uriRequest)
        {
            $uriPatterns = $this->processUriPattern($this->uri);

            if (is_array($uriPatterns)) {
                foreach ($uriPatterns AS $uriPattern) {
                    if ($this->equalsUriPattern($uriRequest, $uriPattern))
                        return true;
                }
            } else if ($this->equalsUriPattern($uriRequest, $uriPatterns)) {
                return true;
            }

            return false;
        }

        private function equalsUriPattern($uriRequest, $uriPattern)
        {
            if (preg_match($uriPattern, $uriRequest, $matches) != false) {
                $index = 0;

                foreach ($this->matches AS $key => &$value)
                    $value = $matches[++$index];

                return true;
            }

            return false;
        }

        public function action()
        {
            $callback = $this->action;

            if (is_object($this->action) == false)
                $callback = explode('@', $this->action);

            $class    = trim($callback[0]);
            $method   = trim($callback[1]);
            $instance = new $class();

            @call_user_func_array([
                $instance,
                $method
            ], $this->matches);
        }

        public static function createInstance($uri, $action, $method = REQUEST_METHOD_GET)
        {
            return new Uri($uri, $action, $method);
        }

        public static function processUri($uri)
        {
            if (is_array($uri)) {
                foreach ($uri AS &$value)
                    $value = self::processUri($value);

                return $uri;
            }

            $uri      = trim($uri);
            $parse    = parse_url($uri);
            $urlPath  = HTTP_SEPARATOR;
            $rootPath = env('base_path');

            if (isset($parse['path']))
                $urlPath = trim($parse['path']);

            $filePath = separator($rootPath . $urlPath);

            if (strrpos($filePath, SP) === strlen($filePath) - 1) {
                $filePath = substr($filePath, 0, strlen($filePath) - 1);
                $urlPath  = substr($urlPath,  0, strlen($urlPath)  - 1);
            }

            return $urlPath;
        }

        protected function processUriPattern($uri)
        {
            if (is_array($uri)) {
                $uriPatternArray = array();

                foreach ($uri AS $value)
                    $uriPatternArray[] = $this->processUriPattern($value);

                return $uriPatternArray;
            }

            $uriPattern = preg_replace_callback('/\{([a-zA-Z0-9\-_]+)\}/si', array($this, 'processUriPatternCallback'), $uri);
            $uriPattern = str_replace('/', '\\/', $uriPattern);
            $uriPattern = str_replace('.', '\\.', $uriPattern);
            $uriPattern = '/^' . $uriPattern . '$/';

            return $uriPattern;
        }

        protected function processUriPatternCallback($matches)
        {
            $matches[1] = trim($matches[1]);

            if (array_key_exists($matches[1], $this->matches))
                return '(' . $this->matches[$matches[1]] . ')';

            return null;
        }

    }
