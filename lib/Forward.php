<?php

    namespace Lib;

    final class Forward
    {

        private static $instance;
        private $fileInclude;

        protected function __construct($fileInclude)
        {
            $this->fileInclude = $fileInclude;
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
        }

        public static function get()
        {

        }

    }
