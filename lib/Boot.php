<?php

    namespace Lib;

    use Lib\Database\DatabaseConnect;

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
            $template    = Template::getInstance();
            $dbConfig    = env('database', null);

            if (is_array($dbConfig)) {
                $dbInstance = DatabaseConnect::getInstance();
                $dbInstance->setDatabaseOnArray($dbConfig);
                $dbInstance->doConnect();
            }

            if (is_array(env('template'))) {
                $template->setTemplateDirectory(env('template.views_directory'));
                $template->setCompileDirectory (env('template.compiles_directory'));
                $template->setCacheDirectory   (env('template.caches_directory'));
                $template->setPluginDirectory  (env('template.plugins_directory'));
            }

            $forward->run();
        }

    }
