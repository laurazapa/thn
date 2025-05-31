<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;

class UuidValueObject
{
    public function __construct(private string $value)
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidRequestException(sprintf('<%s> does not allow the value <%s>.', self::class, $value));
        }
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): string
    {
        return $this->value;
    }
}
