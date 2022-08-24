<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use DateTime;
use DateTimeImmutable;
use Src\Shared\Domain\DateUtils;
use Stringable;

abstract class NullableDateValueObject implements Stringable
{
    private DateTime|DateTimeImmutable|null $value;

    final public function __construct(string|null $value)
    {
        $this->value = null !== $value ? DateUtils::stringToDate($value)->setTime(0, 0, 0, 0) : null;
    }

    public static function now(): static
    {
        return new static(DateUtils::stringToDate('now')->format('Y-m-d'));
    }

    public function value(): DateTime|DateTimeImmutable|null
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return null !== $this->value() ?
            $this->value()->format('Y-m-d') :
            '';
    }
}
