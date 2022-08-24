<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use DateTime;
use DateTimeImmutable;
use Src\Shared\Domain\DateUtils;
use Stringable;

abstract class NullableDatetimeValueObject implements Stringable
{
    private DateTime|DateTimeImmutable|null $value;

    final public function __construct(string|null $value, string $timezone = 'UTC')
    {
        $this->value = null !== $value ? DateUtils::stringToDate($value, timezone: $timezone) : null;
    }

    public static function now(): static
    {
        return new static(DateUtils::nowString());
    }

    public function timezone(string $timezone): self
    {
        if (null === $this->value) {
            return new static(null, $timezone);
        }

        return new static($this->__toString(), $timezone);
    }

    public function value(): DateTime|DateTimeImmutable|null
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return null !== $this->value() ? DateUtils::dateToString($this->value()) : '';
    }
}
