<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use RuntimeException;

abstract class Hash extends StringValueObject
{
    private int $memory  = 1024;
    private int $time    = 2;
    private int $threads = 2;

    public function __construct(protected string $value)
    {
        $this->value = $this->hashValue($this->value);
    }

    protected function algorithm(): string
    {
        return PASSWORD_ARGON2ID;
    }

    /** @SuppressWarnings(PHPMD.BooleanArgumentFlag) */
    public function check(string $other, bool $verifyAlgorithm = false): bool
    {
        if ($verifyAlgorithm && $this->algorithm() !== password_get_info($this->value())['algoName']) {
            throw new RuntimeException(sprintf('This password does not use the %s algorithm.', $this->algorithm()));
        }

        if (strlen($other) === 0) {
            return false;
        }

        return password_verify($other, $this->value());
    }

    public function needsRehash(): bool
    {
        return password_needs_rehash($this->value(), $this->algorithm(), [
            'memory_cost' => $this->memory(),
            'time_cost'   => $this->time(),
            'threads'     => $this->threads(),
        ]);
    }

    protected function memory(): int
    {
        return $this->memory;
    }

    protected function time(): int
    {
        return $this->time;
    }

    protected function threads(): int
    {
        return $this->threads;
    }

    private function hashValue(string $value): string
    {
        if ('unknown' !== password_get_info($this->value())['algoName']) {
            return $value;
        }

        $hash = password_hash($value, $this->algorithm(), [
            'memory_cost' => $this->memory(),
            'time_cost'   => $this->time(),
            'threads'     => $this->threads(),
        ]);

        if (!is_string($hash)) {
            throw new RuntimeException(sprintf('%s hashing not supported.', $this->algorithm()));
        }

        return $hash;
    }
}
