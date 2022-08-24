<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use Src\Shared\Domain\StrUtils;
use InvalidArgumentException;
use Stringable;

abstract class Slug implements Stringable
{
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidSlug($value);

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function ensureIsValidSlug(string $value): void
    {
        if ($value !== StrUtils::slug($value)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $value));
        }
    }
}
