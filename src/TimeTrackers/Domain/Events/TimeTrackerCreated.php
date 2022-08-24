<?php

declare(strict_types=1);

namespace Src\TimeTracker\Domain\Events;

use Src\Shared\Domain\Audits\Events\Auditable;
use Src\Shared\Domain\Bus\Event\DomainEvent;

final class TimeTrackerCreated extends DomainEvent implements Auditable
{
    public function __construct(
        string $id,
        private string $name,
        private string $startsAtTime,
        private ?string $endsAtTime,
        private string $createdAt,
        private string $updatedAt,
        string $eventId = null,
        string $occurredAt = null,
    ) {
        parent::__construct($id, $eventId, $occurredAt);
    }

    public static function eventName(): string
    {
        return 'degustabox.1.event.time_tracker.created';
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
            $body['starts_at_time'],
            $body['ends_at_time'],
            $eventId,
            $occurredAt,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'name'           => $this->name,
            'starts_at_time' => $this->startsAtTime,
            'ends_at_time'   => $this->endsAtTime,
            'created_at'     => $this->createdAt,
            'updated_at'     => $this->updatedAt,
        ];
    }

    public function name(): string
    {
        return $this->name;
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
}
