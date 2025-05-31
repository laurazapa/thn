<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\ValueObject;

use Carbon\Carbon;

abstract class DateValueObject
{
    public function __construct(private Carbon $value)
    {
    }

    public function __toString(): string
    {
        return $this->value()->toString();
    }

    public function value(): Carbon
    {
        return $this->value;
    }
}
