<?php

    namespace Lib\MVC\Views;

    use Lib\Template;

    abstract class View
    {

        const SYMBOL_SPLIT = '.';

        public function view($filename)
        {
            $names = $filename;

            if (strpos($filename, self::SYMBOL_SPLIT) === false)
                $names = [ $filename ];
            else
                $names = explode(self::SYMBOL_SPLIT, $filename);

            $path = implode(HTTP_SEPARATOR, $names) . Template::MIME;

            return Template::getInstance()->display($path);
        }

    }
