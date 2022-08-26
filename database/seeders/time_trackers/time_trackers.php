<?php

use Illuminate\Support\Facades\Date;
use Src\Shared\Domain\ValueObject\Uuid;

return [
    [
        'id'             => Uuid::random()->value(),
        'name'           => 'Develop home page',
        'date'           => Date::now()->__toString(),
        'starts_at_time' => '08:00:00',
        'ends_at_time'   => '09:34:22',
    ],
    [
        'id'             => Uuid::random()->value(),
        'name'           => 'Develop table page',
        'date'           => Date::now()->__toString(),
        'starts_at_time' => '09:35:22',
        'ends_at_time'   => '11:25:00',
    ],
    [
        'id'             => Uuid::random()->value(),
        'name'           => 'Develop controllers',
        'date'           => Date::now()->__toString(),
        'starts_at_time' => '11:26:00',
        'ends_at_time'   => '12:08:00',
    ],
    [
        'id'             => Uuid::random()->value(),
        'name'           => 'Develop scripts',
        'date'           => Date::now()->__toString(),
        'starts_at_time' => '13:45:00',
        'ends_at_time'   => '14:08:00',
    ],
];
