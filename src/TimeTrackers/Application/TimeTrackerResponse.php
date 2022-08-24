<?php

declare(strict_types=1);

namespace Src\TimeTracker\Application;

use Src\Shared\Domain\TimeTrackers\TimeTrackerId;
use Src\TimeTracker\Domain\TimeTrackerCreatedAt;
use Src\TimeTracker\Domain\TimeTrackerEndsAtTime;
use Src\TimeTracker\Domain\TimeTrackerName;
use Src\TimeTracker\Domain\TimeTrackerStartsAtTime;
use Src\TimeTracker\Domain\TimeTrackerUpdatedAt;
use Src\Shared\Domain\Bus\Query\Response;

final class TimeTrackerResponse implements Response
{
    public function __construct(
        private TimeTrackerId $id,
        private TimeTrackerName $name,
        private TimeTrackerStartsAtTime $startsAtTime,
        private TimeTrackerEndsAtTime $endsAtTime,
        private TimeTrackerCreatedAt $createdAt,
        private TimeTrackerUpdatedAt $updatedAt,
    ) {
    }

    public function id(): string
    {
        return $this->id->value();
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function startsAtTime(): string
    {
        return $this->startsAtTime->__toString();
    }

    public function endsAtTime(): ?string
    {
        return null !== $this->endsAtTime->value() ? $this->endsAtTime->__toString() : null;
    }

    public function createdAt(): string
    {
        return $this->createdAt->__toString();
    }

    public function updatedAt(): string
    {
        return $this->updatedAt->__toString();
    }
}
