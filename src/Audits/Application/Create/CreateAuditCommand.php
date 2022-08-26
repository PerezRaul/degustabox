<?php

declare(strict_types=1);

namespace Src\Audits\Application\Create;

use Src\Shared\Domain\Bus\Command\Command;

final class CreateAuditCommand implements Command
{
    public function __construct(
        private string $id,
        private string $aggregateId,
        private string $eventName,
        private string $occurredAt,
        private array $body,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventName(): string
    {
        return $this->eventName;
    }

    public function occurredAt(): string
    {
        return $this->occurredAt;
    }

    public function body(): array
    {
        return $this->body;
    }
}
