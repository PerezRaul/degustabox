<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use DateTimeZone;
use InvalidArgumentException;

abstract class Timezone extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidTimezone($value);
        parent::__construct($value);
    }

    private function ensureIsValidTimezone(string $value): void
    {
        if (!in_array($value, DateTimeZone::listIdentifiers())) {
            throw new InvalidArgumentException(sprintf('The timezone <%s> is invalid.', $this->value));
        }
    }
}
