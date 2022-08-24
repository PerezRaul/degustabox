<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Exceptions\InvalidValue;
use InvalidArgumentException;
use libphonenumber\PhoneNumber as LibPhoneNumber;
use libphonenumber\PhoneNumberFormat as LibPhoneNumberFormat;
use libphonenumber\PhoneNumberUtil as LibPhoneNumberUtil;
use Stringable;
use Throwable;

class NullablePhoneNumber implements Stringable
{
    protected ?array $allowedTypes = null;

    public const FIXED_LINE           = 0;
    public const MOBILE               = 1;
    public const FIXED_LINE_OR_MOBILE = 2;
    public const TOLL_FREE            = 3;
    public const PREMIUM_RATE         = 4;
    public const SHARED_COST          = 5;
    public const VOIP                 = 6;
    public const PERSONAL_NUMBER      = 7;
    public const PAGER                = 8;
    public const UAN                  = 9;
    public const UNKNOWN              = 10;
    public const EMERGENCY            = 27;
    public const VOICEMAIL            = 28;
    public const SHORT_CODE           = 29;
    public const STANDARD_RATE        = 30;

    private ?LibPhoneNumberUtil $phoneUtil = null;
    private ?LibPhoneNumber $phoneNumber = null;

    public function __construct(protected ?string $value, string $countryCode = null)
    {
        if (null !== $value) {
            $this->parsePhoneNumber($value, $countryCode);
            $this->ensureValueInAllowedTypes();
        }
    }

    private function parsePhoneNumber(string $value, ?string $countryCode): void
    {
        $this->phoneUtil = LibPhoneNumberUtil::getInstance();

        try {
            $phoneNumber = $this->phoneUtil->parse($value, $countryCode);
        } catch (Throwable) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $value));
        }

        if (!$phoneNumber instanceof LibPhoneNumber || !$this->phoneUtil->isValidNumber($phoneNumber)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $value));
        }

        $this->phoneNumber = $phoneNumber;

        $this->value = $this->phoneUtil->format($this->phoneNumber, LibPhoneNumberFormat::E164);
    }

    private function ensureValueInAllowedTypes(): void
    {
        if (null === $this->allowedTypes) {
            return;
        }

        if (!in_array($this->numberType(), $this->allowedTypes)) {
            throw new InvalidValue(static::class, strval($this->value));
        }
    }

    public function phoneWithoutCountryCode(): ?string
    {
        if (null === $this->national()) {
            return null;
        }

        return str_replace(' ', '', $this->national());
    }

    public function countryCode(): ?int
    {
        return $this->phoneNumber?->getCountryCode();
    }

    public function national(): ?string
    {
        if (null === $this->phoneNumber) {
            return null;
        }

        return $this->phoneUtil?->format($this->phoneNumber, LibPhoneNumberFormat::NATIONAL);
    }

    public function international(): ?string
    {
        if (null === $this->phoneNumber) {
            return null;
        }

        return $this->phoneUtil?->format($this->phoneNumber, LibPhoneNumberFormat::INTERNATIONAL);
    }

    public function numberType(): ?int
    {
        if (null === $this->phoneNumber) {
            return null;
        }

        return $this->phoneUtil?->getNumberType($this->phoneNumber);
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value() ?? '';
    }
}
