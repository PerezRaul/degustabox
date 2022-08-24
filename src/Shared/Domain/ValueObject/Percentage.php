<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

abstract class Percentage extends IntValueObject
{
    protected float|int|null $min = 0;
    protected float|int|null $max = 100;
}
