<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class NullableEmail extends NullableStringValueObject
{
    public function __construct(protected ?string $value)
    {
        parent::__construct($value);

        if (null !== $value) {
            $this->ensureIsValidEmail($value);
        }
    }

    private function ensureIsValidEmail(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $value));
        }
    }
}
