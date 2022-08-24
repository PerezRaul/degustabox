<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use DateTime;
use DateTimeImmutable;
use Src\Shared\Domain\DateUtils;
use Stringable;

abstract class NullableTimeValueObject implements Stringable
{
    private DateTime|DateTimeImmutable|null $value;

    final public function __construct(string|null $value, string $timezone = null)
    {
        $this->value = null !== $value ?
            DateUtils::stringToDate($value, timezone: $timezone ?? date_default_timezone_get()) :
            null;
    }

    public static function now(): static
    {
        return new static(DateUtils::stringToDate('now')->format('H:i:s'));
    }

    public function timezone(string $timezone): self
    {
        if (null === $this->value) {
            return new static(null);
        }

        return new static($this->__toString(), $timezone);
    }

    public function value(): DateTime|DateTimeImmutable|null
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return null !== $this->value() ?
            $this->value()->format('H:i:s') :
            '';
    }
}
