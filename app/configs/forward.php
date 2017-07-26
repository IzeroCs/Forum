<?php

    Forward::request([
        '/',
        '/index',
        '/index.php',
        '/index.html'
    ], 'Controller\HomeController@index');

    Forward::request('/forum/{id}/{title}', 'Controller\ForumController@index')->match([
        'id'    => '[0-9]+',
        'title' => '[a-zA-Z0-9\-_]+'
    ]);
