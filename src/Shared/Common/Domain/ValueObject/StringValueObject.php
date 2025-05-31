<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\ValueObject;

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

    public function equals(StringValueObject $other): bool
    {
        return $this->value() === $other->value();
    }
}
