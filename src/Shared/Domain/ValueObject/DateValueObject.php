<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use DateTime;
use DateTimeImmutable;
use Src\Shared\Domain\DateUtils;
use Stringable;

abstract class DateValueObject implements Stringable
{
    private DateTime|DateTimeImmutable $value;

    final public function __construct(string $value)
    {
        $this->value = DateUtils::stringToDate($value)->setTime(0, 0, 0, 0);
    }

    public static function now(): static
    {
        return new static(DateUtils::stringToDate('now')->format('Y-m-d'));
    }

    public function value(): DateTime|DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format('Y-m-d');
    }
}
