<?php

    namespace Lib;

    use \Smarty;

    final class Template
    {

        private static $instance;
        private $smarty;

        const MIME = '.tpl';

        protected function __construct()
        {
            self::$instance = $this;
            $this->smarty   = new Smarty();
        }

        protected function __clone()
        {

        }

        protected function __wakeup()
        {

        }

        public static function getInstance()
        {
            if (null === self::$instance)
                self::$instance = new Template();

            return self::$instance;
        }

        public function setTemplateDirectory($directory)
        {
            $this->smarty->setTemplateDir($directory);
        }

        public function setCompileDirectory($directory)
        {
            $this->smarty->setCompileDir($directory);
        }

        public function setCacheDirectory($directory)
        {
            $this->smarty->setCacheDir($directory);
        }

        public function setPluginDirectory($directory)
        {
            $this->smarty->setPluginsDir($directory);
        }

        public function display($filename)
        {
            return $this->smarty->display($filename);
        }

    }
