<?php

    namespace Lib;

    use Lib\Environment\EnvBaseAbs;

    final class Environment
    {

        private static $instance;

        private $array;
        private $cache;

        const PREFIX_NAMESPACE_ENV_BLOCK = 'Lib\\Environment\\';
        const PREFIX_NAME_ENV_BLOCK      = 'Env';
        const METHOD_CALL_ENV_BLOCK      = 'invoke';

        protected function __construct(array $array)
        {
            $this->array = $array;
            $this->cache = array();
        }

        public static function getInstance($array = null)
        {
            if (null === self::$instance) {
                if (null === $array)
                    trigger_error('Error array environment');

                self::$instance = new Environment($array);
            }

            return self::$instance;
        }

        public function get($name, $default = null)
        {
            if (preg_match('/^(SERVER|POST|GET|REQUEST|GLOBALS|COOKIE|SESSION)(\.(.*?))?$/s', $name, $matches)) {
                if ($matches[1] != 'GLOBALS')
                    $matches[1] = '_' . $matches[1];

                if (count($matches) <= 2) {
                    if (isset($GLOBALS[$matches[1]]))
                        return $GLOBALS[$matches[1]];

                    return null;
                }

                if (isset($GLOBALS[$matches[1]]) == false)
                    return null;

                return $this->resolve($matches[3], $default, $GLOBALS[$matches[1]]);
            }

            if (array_key_exists($name, $this->cache))
                return $this->cache[$name];

            return ($this->cache[$name] = urlSeparatorMatches($this->resolve($name, $default)));
        }

        private function resolve($key, $default = null, $array = null)
        {
            if (is_string($key) && empty($key) == false) {
                if ($array == null)
                    $array = $this->array;

                $keys  = explode('.', $key);

                if (is_array($keys) == false)
                    $keys = array($key);

                foreach ($keys AS $entry) {
                    $entry = trim($entry);

                    if (array_key_exists($entry, $array) == false)
                        return $default;

                    $array = $array[$entry];
                }

                $result = $this->envMatchesString($array);
                $result = $this->envMatchesBlock($result);

                return $result;
            }

            return $default;
        }

        public static function envMatchesString($str)
        {
            $pattern = '/\$\{(.+?)\}/si';

            if (is_array($str) || preg_match($pattern, $str) == false)
                return $str;

            return preg_replace_callback($pattern, function($matches) {
                $result = null;

                if (isset($GLOBALS[$matches[1]]))
                    $result = $GLOBALS[$matches[1]];
                else if (defined($matches[1]))
                    $result = constant($matches[1]);
                else
                    $result = env(trim($matches[1]));

                if (is_array($result))
                    return 'Array';
                else if (is_object($result))
                    return 'Object';
                else if (is_resource($result))
                    return 'Resource';
                return $result;
            }, $str);
        }

        private function envMatchesBlock($str)
        {
            $pattern = '/(\$([a-zA-Z0-9\-\_]+)\{(.+?)\})/si';

            if (is_array($str) || preg_match($pattern, $str) == false)
                return $str;

            return preg_replace_callback($pattern, function($matches) {
                $name     = trim($matches[2]);
                $params   = trim($matches[3]);
                $class    = self::PREFIX_NAMESPACE_ENV_BLOCK . self::PREFIX_NAME_ENV_BLOCK . ucfirst($name);

                if (method_exists($class, self::METHOD_CALL_ENV_BLOCK)) {
                    return @call_user_func_array([
                        $class,
                        self::METHOD_CALL_ENV_BLOCK
                    ], [
                        EnvBaseAbs::processParams($params, $matches[0])
                    ]);
                }

                return $matches[0];
            }, $str);
        }

        private function __clone()
        {

        }

        private function __wakeup()
        {

        }

    }
