<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Domain\Filters;

use Src\Shared\Domain\Criteria\FilterOperator;
use Src\Shared\Domain\Criteria\FilterParser;

final class DateFilterParser extends FilterParser
{
    public static function get(mixed $value): ?array
    {
        return [
            [
                'field'    => 'date',
                'operator' => FilterOperator::CONTAINS,
                'value'    => $value,
            ],
        ];
    }
}
