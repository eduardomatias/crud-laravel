<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => '',
        'host'           => env('DB_HOST', '127.0.0.1'),
        'port'           => env('DB_PORT', '1521'),
        'service_name'   => env('DB_SERVICE', ''),
        'database'       => env('DB_DATABASE', ''),
        'username'       => env('DB_USERNAME', ''),
        'password'       => env('DB_PASSWORD', ''),
        'charset'        => 'AL32UTF8',
        'prefix'         => '',
        'prefix_schema'  => '',
        'server_version' => '11g',
    ],
];
