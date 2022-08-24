<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class Ip extends StringValueObject
{
    public function __construct(protected string $value)
    {
        parent::__construct($value);
        $this->ensureIsValidIp($value);
    }

    private function ensureIsValidIp(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $value));
        }
    }
}
