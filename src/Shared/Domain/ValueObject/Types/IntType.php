<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject\Types;

final class IntType implements Type
{
    public function passes(mixed $value): bool
    {
        return is_integer($value);
    }
}
