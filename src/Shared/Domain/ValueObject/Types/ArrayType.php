<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject\Types;

final class ArrayType implements Type
{
    public function passes(mixed $value): bool
    {
        return is_array($value);
    }
}
