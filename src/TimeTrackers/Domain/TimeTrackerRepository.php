<?php

declare(strict_types=1);

namespace Src\TimeTracker\Domain;

use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\TimeTrackers\TimeTrackerId;

interface TimeTrackerRepository
{
    public function save(TimeTrackers $timeTracker): void;

    public function search(TimeTrackerId $id): ?TimeTrackers;

    public function matching(Criteria $criteria): TimeTrackers;

    public function matchingCount(Criteria $criteria): int;
}
