<?php

    namespace Lib\Database\Extension;

    use Lib\Database\DatabaseInterface;

    class MysqliExtension implements DatabaseInterface
    {

        private static $instance;

        protected function __construct()
        {
            self::$instance = $this;
        }

        protected function __clone()
        {

        }

        protected function __wakeup()
        {

        }

        public function connect(
            $dbHost,
            $dbUsername,
            $dbPassword,
            $dbName
        ) {

        }

        public static function isSupported()
        {
            return @function_exists('mysqli_connect');
        }

        public static function getInstance()
        {
            if (null === self::$instance)
                self::$instance = new MysqliExtension();

            return self::$instance;
        }

        public function disconnect()
        {

        }

        public function free()
        {

        }

    }
