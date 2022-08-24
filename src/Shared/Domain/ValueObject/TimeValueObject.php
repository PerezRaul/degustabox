<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use DateTime;
use DateTimeImmutable;
use Src\Shared\Domain\DateUtils;
use Stringable;

abstract class TimeValueObject implements Stringable
{
    private DateTime|DateTimeImmutable $value;

    final public function __construct(string $value, string $timezone = null)
    {
        $this->value = DateUtils::stringToDate($value, timezone: $timezone ?? date_default_timezone_get());
    }

    public static function now(): static
    {
        return new static(DateUtils::stringToDate('now')->format('H:i:s'));
    }

    public function timezone(string $timezone): self
    {
        return new static($this->__toString(), $timezone);
    }

    public function value(): DateTime|DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format('H:i:s');
    }
}
