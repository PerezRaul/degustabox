<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Domain\Filters;

use Src\Shared\Domain\Criteria\FilterParserFactory;

final class TimeTrackerFilterParserFactory extends FilterParserFactory
{
    protected static function mapping(): array
    {
        return [
            'date'   => DateFilterParser::class,
            'search' => SearchFilterParser::class,
        ];
    }
}
