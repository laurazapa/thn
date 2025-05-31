<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\ValueObject;

use Src\Shared\Common\Domain\Exception\InvalidRequestException;

abstract class EmailValueObject
{
    public function __construct(public string $value)
    {
        if (!self::isValid($value)) {
            throw new InvalidRequestException(sprintf('<%s> does not allow the value <%s>.', self::class, $value));
        }
    }

    public static function isValid(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function value(): string
    {
        return $this->value;
    }
}
