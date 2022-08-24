<?php

return [
    'scan_dirs' => [
        base_path('src/**/*'),
    ],
    'event'   => [
        'connection'  => env('EVENT_DRIVER', 'rabbitmq'),
        'connections' => [
            'memory'   => [
                'driver' => 'memory',
            ],
            'rabbitmq' => [
                'driver'          => 'rabbitmq',
                'host'            => env('RABBITMQ_HOST'),
                'port'            => env('RABBITMQ_PORT'),
                'vhost'           => env('RABBITMQ_VHOST', '/'),
                'login'           => env('RABBITMQ_LOGIN'),
                'password'        => env('RABBITMQ_PASSWORD'),
                'exchange'        => env('RABBITMQ_EXCHANGE', 'domain_events'),
                'read_timeout'    => env('RABBITMQ_READ_TIMEOUT', 2),
                'write_timeout'   => env('RABBITMQ_WRITE_TIMEOUT', 2),
                'connect_timeout' => env('RABBITMQ_CONNECT_TIMEOUT', 5),
                'max_retries'     => env('RABBITMQ_MAX_RETRIES', 5)
            ]
        ],
    ],
    'query'   => [],
    'command' => [],
];
