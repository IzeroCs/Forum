<?php

    namespace Lib\Database;

    interface DatabaseInterface
    {

        public function connect(
            $dbHost,
            $dbUsername,
            $dbPassword,
            $dbName
        );

        public function disconnect();

        public function free();

        public static function isSupported();

        public static function getInstance();

    }
