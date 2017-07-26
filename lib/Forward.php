<?php

    namespace Lib;

    use Lib\Forward\Uri;

    final class Forward
    {

        private static $instance;
        private $fileInclude;
        private $uriRequest;
        private $methodRequest;
        private $uriEntrys;

        protected function __construct($fileInclude)
        {
            $this->uriEntrys     = array();
            $this->fileInclude   = $fileInclude;
            $this->uriRequest    = Uri::processUri($_SERVER['REQUEST_URI']);
            $this->methodRequest = trim($_SERVER['REQUEST_METHOD']);
        }

        public static function getInstance($fileInclude = null)
        {
            if (null === self::$instance)
                self::$instance = new Forward($fileInclude);

            return self::$instance;
        }

        private function __clone()
        {

        }

        private function __wakeup()
        {

        }

        public function run()
        {
            require_once($this->fileInclude);

            if (is_array($this->uriEntrys) == false)
                return;

            foreach ($this->uriEntrys AS $uriHash => $uriObject) {
                if ($uriObject->equals($this->uriRequest, $this->methodRequest)) {
                    $uriObject->action();
                    return;
                }
            }
        }

        private function makeUri($uri, $action, $method)
        {
            if (is_array($uri))
                $uriHash = md5(serialize($uri));
            else
                $uriHash = md5($uri);

            $uriObject = null;

            if (array_key_exists($uriHash, $this->uriEntrys) == false) {
                $uriObject                 = Uri::createInstance($uri, $action, $method);
                $this->uriEntrys[$uriHash] = $uriObject;
            } else {
                $uriObject = $this->uriEntrys[$uriHash];
            }

            return $uriObject;
        }

        public static function request($uri, $action, $method = REQUEST_METHOD_GET)
        {
            return self::$instance->makeUri($uri, $action, $method);
        }

    }
