<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Domain\Services;

use Src\Shared\Domain\TimeTrackers\TimeTrackerId;
use Src\TimeTrackers\Domain\TimeTracker;
use Src\TimeTrackers\Domain\TimeTrackerRepository;
use Src\Shared\Domain\Exceptions\NotExists;

final class TimeTrackerFinder
{
    public function __construct(private TimeTrackerRepository $repository)
    {
    }

    public function __invoke(TimeTrackerId $id): TimeTracker
    {
        return $this->repository->search($id) ?? throw new NotExists(TimeTracker::class, $id);
    }
}
