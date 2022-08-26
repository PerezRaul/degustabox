<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Domain;

use Src\Shared\Domain\Aggregate\AggregateRoot;
use Src\Shared\Domain\TimeTrackers\TimeTrackerId;
use Src\TimeTrackers\Domain\Events\TimeTrackerCreated;
use Src\TimeTrackers\Domain\Events\TimeTrackerUpdated;

final class TimeTracker extends AggregateRoot
{
    public function __construct(
        protected TimeTrackerId $id,
        protected TimeTrackerName $name,
        protected TimeTrackerDate $date,
        protected TimeTrackerStartsAtTime $startsAtTime,
        protected TimeTrackerEndsAtTime $endsAtTime,
        protected TimeTrackerCreatedAt $createdAt,
        protected TimeTrackerUpdatedAt $updatedAt,
    ) {
    }

    public static function create(
        TimeTrackerId $id,
        TimeTrackerName $name,
        TimeTrackerDate $date,
        TimeTrackerStartsAtTime $startsAtTime,
        TimeTrackerEndsAtTime $endsAtTime,
        TimeTrackerCreatedAt $createdAt,
        TimeTrackerUpdatedAt $updatedAt,
    ): self {
        $timeTracker = new self(
            $id,
            $name,
            $date,
            $startsAtTime,
            $endsAtTime,
            $createdAt,
            $updatedAt,
        );

        $timeTracker->wasRecentlyCreated = true;

        $timeTracker->record(new TimeTrackerCreated(
            $id->value(),
            $name->value(),
            $date->__toString(),
            $startsAtTime->__toString(),
            null !== $endsAtTime->value() ? $endsAtTime->__toString() : null,
            $createdAt->__toString(),
            $updatedAt->__toString(),
        ));

        return $timeTracker;
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            new TimeTrackerId($primitives['id']),
            new TimeTrackerName($primitives['name']),
            new TimeTrackerDate($primitives['date']),
            new TimeTrackerStartsAtTime($primitives['starts_at_time']),
            new TimeTrackerEndsAtTime($primitives['ends_at_time']),
            new TimeTrackerCreatedAt($primitives['created_at']),
            new TimeTrackerUpdatedAt($primitives['updated_at']),
        );
    }

    public function update(
        TimeTrackerId|TimeTrackerName|TimeTrackerDate|TimeTrackerStartsAtTime|TimeTrackerEndsAtTime|TimeTrackerUpdatedAt ...$data
    ): void {
        $this->applyChanges(...$data);

        $this->recordOnChanges(new TimeTrackerUpdated(
            $this->id->value(),
            $this->name->value(),
            $this->date->__toString(),
            $this->startsAtTime->__toString(),
            null !== $this->endsAtTime->value() ? $this->endsAtTime->__toString() : null,
            $this->createdAt->__toString(),
            $this->updatedAt->__toString(),
            $this->changes(),
        ));
    }

    public function toPrimitives(): array
    {
        return [
            'id'             => $this->id->value(),
            'name'           => $this->name->value(),
            'date'           => $this->date->__toString(),
            'starts_at_time' => $this->startsAtTime->__toString(),
            'ends_at_time'   => null !== $this->endsAtTime->value() ? $this->endsAtTime->__toString() : null,
            'created_at'     => $this->createdAt->__toString(),
            'updated_at'     => $this->updatedAt->__toString(),
        ];
    }

    public function id(): TimeTrackerId
    {
        return $this->id;
    }

    public function name(): TimeTrackerName
    {
        return $this->name;
    }

    public function date(): TimeTrackerDate
    {
        return $this->date;
    }

    public function startsAtTime(): TimeTrackerStartsAtTime
    {
        return $this->startsAtTime;
    }

    public function endsAtTime(): TimeTrackerEndsAtTime
    {
        return $this->endsAtTime;
    }

    public function createdAt(): TimeTrackerCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): TimeTrackerUpdatedAt
    {
        return $this->updatedAt;
    }
}
