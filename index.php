<?php

    if (defined('SP') == false)
        define('SP', DIRECTORY_SEPARATOR);

    if (defined('DS') == false)
        define('DS', DIRECTORY_SEPARATOR);

    $loader = require_once('vendor' . SP . 'autoload.php');
    $boot   = Lib\Boot::getInstance(
        require_once('assets' . SP . 'config' . SP . 'app.php'),
                    ('assets' . SP . 'config' . SP . 'forward.php')
    );
    $boot->run();

?>