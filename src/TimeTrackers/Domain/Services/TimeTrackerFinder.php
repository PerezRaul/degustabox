<?php

declare(strict_types=1);

namespace Src\TimeTracker\Domain\Services;

use Src\Shared\Domain\TimeTrackers\TimeTrackerId;
use Src\TimeTracker\Domain\TimeTrackers;
use Src\TimeTracker\Domain\TimeTrackerRepository;
use Src\Shared\Domain\Exceptions\NotExists;

final class TimeTrackerFinder
{
    public function __construct(private TimeTrackerRepository $repository)
    {
    }

    public function __invoke(TimeTrackerId $id): TimeTrackers
    {
        return $this->repository->search($id) ?? throw new NotExists(TimeTrackers::class, $id);
    }
}
