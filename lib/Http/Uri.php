<?php

    namespace Lib\Http;

    class Uri
    {

        const SCHEME_HTTP  = 'http';
        const SCHEME_HTTPS = 'https';

        protected function __construct()
        {

        }

        protected function __clone()
        {

        }

        protected function __wakeup()
        {

        }

        public static function urlAddPrefixScheme($url, $scheme = self::SCHEME_HTTP)
        {
            $separator = '://';

            if (stripos($url, self::SCHEME_HTTP . $separator) === 0)
                return $url;

            if (stripos($url, self::SCHEME_HTTPS . $separator) === 0)
                return $url;

            return $scheme . $separator . $url;
        }

    }
