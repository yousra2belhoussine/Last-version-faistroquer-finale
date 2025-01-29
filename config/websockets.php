<?php

return [
    'host' => env('SOCKET_HOST', '127.0.0.1'),
    'port' => env('SOCKET_PORT', 6001),
    'options' => [
        'cors' => [
            'allowed_origins' => ['*'],
        ],
    ],
]; 