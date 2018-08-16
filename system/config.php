<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */
return [
    'php_least_version'   => '7',
    'database'   => [
        'host'      => 'localhost',
        'name'      => 'adcms',
        'username'  => 'root',
        'password'  => ''
    ],
    'autoload_helpers_files' => ['CommonFunctions', 'Encryption'],       //autoload helpers [write file without prefix]
    'routes'    => [    //routes files without .php  [prefix is _rs]
        CORE_PATH . DS . 'routes' . DS . 'BasicRoutes',    //basic routes
    ],
    'middleware' => [
        'interface' => 'Application\\Middleware\\MiddlewareInterface',   //namespace interface
        'directory' => 'Application\\Middleware\\'    //namespace middleware directory
    ],
    'session'    => [
        'name'          => '$2y$10$sfTkuTaAG8CDw05svZROGjArYkXvp7HY7W2YpBqgfHR9MFhkwG',
        'maxLifeTime'   => 0,
        'SSL'           => false,
        'HTTPOnly'      => true,
        'path'          => '/',
        'domain'        => '.blog.test',
        'savePath'      => APPLICATION_PATH . DS . 'session'. DS . '$2y$10$sfTkuTaAG8CDw05svZROGjAkjjssrYk' . DS,
    ],
    'date' => [
        'set_timezone'      => 'Africa/Cairo'
    ],
];
