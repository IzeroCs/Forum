<?php

    namespace Lib;

    final class Boot
    {

        private static $instance;

        protected function __construct(array $arrayEnv, $fileForward)
        {
            Environment::getInstance($arrayEnv);
            Forward::getInstance($fileForward);
        }

        public static function getInstance(array $arrayEnv, $fileForward)
        {
            if (null === self::$instance)
                self::$instance = new Boot($arrayEnv, $fileForward);

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
            $environment = Environment::getInstance();
            $language    = Language::getInstance();
            $forward     = Forward::getInstance();

            $forward->run();
            console($environment);
        }

    }
