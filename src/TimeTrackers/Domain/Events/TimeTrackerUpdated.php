<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Domain\Events;

use Src\Shared\Domain\Audits\Events\Auditable;
use Src\Shared\Domain\Bus\Event\DomainEvent;

final class TimeTrackerUpdated extends DomainEvent implements Auditable
{
    public function __construct(
        string $id,
        private string $name,
        private string $date,
        private string $startsAtTime,
        private ?string $endsAtTime,
        private string $createdAt,
        private string $updatedAt,
        private array $changes,
        string $eventId = null,
        string $occurredAt = null,
    ) {
        parent::__construct($id, $eventId, $occurredAt);
    }

    public static function eventName(): string
    {
        return 'time-tracker.1.event.time_tracker.updated';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredAt,
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['name'],
            $body['date'],
            $body['starts_at_time'],
            $body['ends_at_time'],
            $body['created_at'],
            $body['updated_at'],
            $body['changes'],
            $eventId,
            $occurredAt,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'name'           => $this->name,
            'date'           => $this->date,
            'starts_at_time' => $this->startsAtTime,
            'ends_at_time'   => $this->endsAtTime,
            'created_at'     => $this->createdAt,
            'updated_at'     => $this->updatedAt,
            'changes'        => $this->changes,
        ];
    }

    public function name(): string
    {
        return $this->name;
    }

    public function date(): string
    {
        return $this->date;
    }

    public function startsAtTime(): string
    {
        return $this->startsAtTime;
    }

    public function endsAtTime(): ?string
    {
        return $this->endsAtTime;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function updatedAt(): string
    {
        return $this->updatedAt;
    }

    public function changes(): array
    {
        return $this->changes;
    }
}
