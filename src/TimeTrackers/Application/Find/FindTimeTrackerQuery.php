<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Application\Find;

use Src\Shared\Domain\Bus\Query\Query;

final class FindTimeTrackerQuery implements Query
{
    public function __construct(private string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
