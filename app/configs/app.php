<?php

    use Lib\Database\DatabaseConnect;

    return [
        'base_path' => dirname(dirname(__DIR__)),

        'http' => [
            'host'        => '$call{Lib\\Http\\Server::takeHttpHost}',
            'public_path' => '${http.host}${HTTP_SEPARATOR}public',

            'res' => [
                'default' => [
                    'app_js'  => '${http.public_path}${HTTP_SEPARATOR}default${HTTP_SEPARATOR}app.js',
                    'app_css' => '${http.public_path}${HTTP_SEPARATOR}default${HTTP_SEPARATOR}app.css'
                ]
            ]
        ],

        'language' => [
            'path'      => '${base_path}${SP}app${SP}langs',
            'mime'      => '.php',
            'split_tag' => '.',

            'locale' => [
                'user'    => 'en',
                'default' => 'en'
            ]
        ],

        'database' => [
            'host'              => 'localhost',
            'username'          => 'root',
            'password'          => '',
            'name'              => 'forum',

            'extension_default' => DatabaseConnect::DATABASE_EXTENSION_MYSQL,
            'extension_support' => DatabaseConnect::DATABASE_EXTENSION_MYSQLI
        ],

        'template' => [
            'base_directory'     => '${base_path}${SP}app${SP}template',
            'lists_directory'    => '${template.base_directory}${SP}lists',
            'current_name'       => 'default',
            'views_directory'    => '${template.lists_directory}${SP}${template.current_name}${SP}views',
            'compiles_directory' => '${template.lists_directory}${SP}${template.current_name}${SP}compiles',
            'caches_directory'   => '${template.lists_directory}${SP}${template.current_name}${SP}caches',
            'plugins_directory'  => '${template.base_directory}${SP}plugins'
        ]
    ];
