<?php

    namespace Lib\Database;

    class DatabaseConnect
    {

        private static $instance;

        private $extensionType;
        private $extensionObject;

        private $dbHost;
        private $dbUsername;
        private $dbPassword;
        private $dbName;

        const DATABASE_EXTENSION_MYSQL  = 'Lib\\Database\\Extension\\MysqlExtension';
        const DATABASE_EXTENSION_MYSQLI = 'Lib\\Database\\Extension\\MysqliExtension';

        private function __construct($extensionType)
        {
            self::$instance      = $this;
            $this->extensionType = $extensionType;
        }

        private function __clone()
        {

        }

        private function __wakeup()
        {

        }

        public static function getInstance($extensionType = self::DATABASE_EXTENSION_MYSQLI)
        {
            if (null === self::$instance)
                self::$instance = new DatabaseConnect($extensionType);

            return self::$instance;
        }

        public function setDatabaseOnArray($configArray)
        {
            if (is_array($configArray) == false)
                return;

            $arrayKeys = [
                'host'     => 'setDatabaseHost',
                'username' => 'setDatabaseUsername',
                'password' => 'setDatabasePassword',
                'name'     => 'setDatabaseName'
            ];

            foreach ($arrayKeys AS $key => $func) {
                if (array_key_exists($key, $configArray))
                    @call_user_func_array(array($this, $func), array($configArray[$key]));
            }

            $extensionTypeDefault = null;
            $extensionTypeSupport = null;

            if (array_key_exists('extension_default', $configArray))
                $extensionTypeDefault = $configArray['extension_default'];

            if (array_key_exists('extension_support', $configArray))
                $extensionTypeSupport = $configArray['extension_support'];

            $this->setDatabaseExtension($extensionTypeDefault, $extensionTypeSupport);
        }

        public function setDatabaseExtension($extensionTypeDefault, $extensionTypeSupport = null)
        {
            $extensionType        = null;
            $extensionObject      = null;
            $extensionIsSupported = false;

            if (null !== $extensionTypeDefault && method_exists($extensionTypeDefault, 'isSupported')) {
                $extensionObject      = call_user_func([ $extensionTypeDefault, 'getInstance' ]);
                $extensionIsSupported = call_user_func([ $extensionTypeDefault, 'isSupported' ]);

                if ($extensionIsSupported)
                    $extensionType = $extensionTypeDefault;
            }

            if ($extensionIsSupported == false && null !== $extensionTypeSupport && method_exists($extensionTypeSupport, 'isSupported')) {
                $extensionObject      = call_user_func([ $extensionTypeSupport, 'getInstance' ]);
                $extensionIsSupported = call_user_func([ $extensionTypeSupport, 'isSupported' ]);

                if ($extensionIsSupported)
                    $extensionType = $extensionTypeSupport;
            }

            if (null !== $extensionObject && $extensionObject instanceof DatabaseInterface) {
                $this->extensionType   = $extensionType;
                $this->extensionObject = $extensionObject;
            }
        }

        public function setDatabaseHost($host)
        {
            $this->dbHost = $host;
        }

        public function getDatabaseHost()
        {
            return $this->dbHost;
        }

        public function setDatabaseUsername($username)
        {
            $this->dbUsername = $username;
        }

        public function getDatabaseUsername()
        {
            return $this->dbUsername;
        }

        public function setDatabasePassword($password)
        {
            $this->dbPassword = $password;
        }

        public function getDatabasePassword()
        {
            return $this->dbPassword;
        }

        public function setDatabaseName($name)
        {
            $this->dbName = $name;
        }

        public function getDatabaseName()
        {
            return $this->dbName;
        }

        public function doConnect()
        {
            if ($this->extensionObject instanceof DatabaseInterface == false)
                trigger_error('Database extension not instanceof DatabaseInterface');

            $this->extensionObject->connect(
                $this->dbHost,
                $this->dbUsername,
                $this->dbPassword,
                $this->dbName
            );
        }

    }
