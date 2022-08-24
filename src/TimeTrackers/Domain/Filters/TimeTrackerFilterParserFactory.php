<?php

declare(strict_types=1);

namespace Src\TimeTracker\Domain\Filters;

use Src\Shared\Domain\Criteria\FilterParserFactory;

final class TimeTrackerFilterParserFactory extends FilterParserFactory
{
    protected static function mapping(): array
    {
        return [
            'search'            => SearchFilterParser::class,
        ];
    }
}
