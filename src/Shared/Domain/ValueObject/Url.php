<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class Url extends StringValueObject
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValidUrl($value);
        parent::__construct($value);
    }

    private function ensureIsValidUrl(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $value));
        }
    }
}
