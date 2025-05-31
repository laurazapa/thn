<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\ValueObject;

/**
 * String Value Object.
 * 
 * This class represents a string value in the domain.
 * It provides validation and type safety for string values.
 * 
 * @extends StringValueObject
 */
abstract class StringValueObject
{
    public function __construct(public string $value)
    {
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
