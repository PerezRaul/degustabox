<?php

use Src\TimeTrackers\Domain\TimeTrackerRepository;
use Src\TimeTrackers\Infrastructure\Persistence\EloquentTimeTrackerRepository;

return [
    'binds'      => [
        //REPOSITORIES
        TimeTrackerRepository::class => EloquentTimeTrackerRepository::class,
    ],
    'singletons' => [],
];
