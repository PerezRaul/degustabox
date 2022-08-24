<?php

use Src\Shared\Domain\Dictionaries\UuidDictionary;

return [
    [
        'id'             => app(UuidDictionary::class)->get(
            'time_trackers.task1',
            '0fdb5267-9e88-423d-a8f4-fc33a318abd8'
        ),
        'name'           => 'Nombre de la tarea número 1',
        'starts_at_time' => '08:00:00',
        'ends_at_time'   => '10:00:00',
    ],
    [
        'id'             => app(UuidDictionary::class)->get(
            'time_trackers.task2',
            'e5badff4-1dcd-4dc8-8758-15ce1859934d'
        ),
        'name'           => 'Nombre de la tarea número 2',
        'starts_at_time' => '11:00:00',
        'ends_at_time'   => '11:25:00',
    ],
];
