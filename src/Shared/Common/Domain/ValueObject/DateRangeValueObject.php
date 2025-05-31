<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\ValueObject;

use Src\Shared\Common\Domain\Exception\InvalidRequestException;

class DateRangeValueObject
{
    public function __construct(public DateValueObject $startDate, public DateValueObject $endDate)
    {
        if (!self::isValid($startDate, $endDate)) {
            throw new InvalidRequestException(
                sprintf(
                    'Start date (%s) must be before end date (%s).',
                    $startDate->value()->format('Y-m-d'),
                    $endDate->value()->format('Y-m-d'),
                )
            );
        }
    }

    public function __toString(): string
    {
        return $this->startDate()->value()->format('Y-m-d') . ',' . $this->endDate()->value()->format('Y-m-d');
    }

    public function startDate(): DateValueObject
    {
        return $this->startDate;
    }

    public function endDate(): DateValueObject
    {
        return $this->endDate;
    }

    public static function isValid(DateValueObject $startDate, DateValueObject $endDate): bool
    {
        return $endDate->value()->gt($startDate->value());
    }
}
