<?php

use Src\TimeTracker\Domain\TimeTrackerRepository;
use Src\TimeTracker\Infrastructure\Persistence\EloquentTimeTrackerRepository;

return [
    'binds'      => [
        //REPOSITORIES
        TimeTrackerRepository::class => EloquentTimeTrackerRepository::class,
    ],
    'singletons' => [],
];
