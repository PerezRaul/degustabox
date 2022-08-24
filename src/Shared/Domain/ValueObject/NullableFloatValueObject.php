<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Traits\HasMinMax;

abstract class NullableFloatValueObject implements NullableFloatValueObjectInterface
{
    use HasMinMax;

    protected int|null $precision = null;

    public function __construct(protected ?float $value)
    {
        $this->ensureValueInRange($value);

        if (null !== $this->value && null !== $this->precision) {
            $this->value = round($this->value, $this->precision);
        }
    }

    public function value(): ?float
    {
        return $this->value;
    }

    public function invertSign(): static
    {
        if (null === $this->value) {
            return new static(null);
        }

        return new static(-1 * $this->value());
    }

    public function add(int|float ...$additions): static
    {
        if (empty($additions)) {
            return $this;
        }

        $value = $this->value ?? 0;
        foreach ($additions as $addition) {
            $value += $addition;
        }

        return new static($value);
    }

    public function subtract(int|float ...$subtractions): static
    {
        if (empty($subtractions)) {
            return $this;
        }

        $value = $this->value ?? 0;
        foreach ($subtractions as $subtraction) {
            $value -= $subtraction;
        }

        return new static($value);
    }

    public function multiply(int|float ...$multipliers): static
    {
        if (empty($multipliers) || null === $this->value) {
            return $this;
        }

        $value = $this->value;
        foreach ($multipliers as $multiplier) {
            $value *= $multiplier;
        }

        return new static($value);
    }

    public function divide(int|float ...$divisions): static
    {
        if (empty($divisions) || null === $this->value) {
            return $this;
        }

        $value = $this->value;
        foreach ($divisions as $division) {
            $value /= $division;
        }

        return new static($value);
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
