<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject\Types;

final class EmailType implements Type
{
    public function passes(mixed $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
