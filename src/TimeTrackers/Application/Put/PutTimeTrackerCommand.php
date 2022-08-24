<?php

declare(strict_types=1);

namespace Src\TimeTracker\Application\Put;

use Src\Shared\Domain\Bus\Command\Command;

final class PutTimeTrackerCommand implements Command
{
    public function __construct(
        private string $id,
        private string $name,
        private string $startsAtTime,
        private ?string $endsAtTime,
    ) {
    }

    public function id(): string
    {
        return $this->id;
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
}
