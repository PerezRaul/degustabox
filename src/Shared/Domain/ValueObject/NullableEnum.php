<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use Stringable;

abstract class NullableEnum extends Enum implements Stringable
{
    public const NULL = null;
}
