<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

abstract class DateModfyType extends Enum
{
    public const DAYS   = 'days';
    public const MONTHS = 'months';
    public const YEARS  = 'years';
}
