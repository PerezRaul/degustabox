<?php

declare(strict_types=1);

namespace Src\TimeTracker\Domain;

use Src\Shared\Domain\Collection;

final class TimeTrackers extends Collection
{
    protected function types(): array
    {
        return [
            TimeTracker::class,
        ];
    }
}
