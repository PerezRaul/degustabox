<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Domain;

use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\TimeTrackers\TimeTrackerId;

interface TimeTrackerRepository
{
    public function save(TimeTracker $timeTracker): void;

    public function search(TimeTrackerId $id): ?TimeTracker;

    public function matching(Criteria $criteria): TimeTrackers;

    public function matchingCount(Criteria $criteria): int;
}
