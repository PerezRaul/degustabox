<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use Stringable;

interface NullableFloatValueObjectInterface extends Stringable
{
    public function __construct(?float $value);

    public function value(): ?float;

    public function invertSign(): static;
}
