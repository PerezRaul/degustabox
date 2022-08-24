<?php

declare(strict_types=1);

namespace Src\TimeTracker\Application;

use Src\Shared\Domain\Bus\Query\Response;

final class TimeTrackersResponse implements Response
{
    private array $timeTrackers;

    public function __construct(TimeTrackerResponse ...$timeTrackers)
    {
        $this->timeTrackers = $timeTrackers;
    }

    public function timeTrackers(): array
    {
        return $this->timeTrackers;
    }
}
