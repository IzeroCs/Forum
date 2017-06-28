<?php

    return [
        'base_path' => dirname(dirname(__DIR__)),

        'language' => [
            'path'      => '${base_path}${SP}assets${SP}lang',
            'mime'      => '.php',
            'split_tag' => '.',

            'locale' => [
                'user'    => 'en',
                'default' => 'en'
            ]
        ]
    ];
