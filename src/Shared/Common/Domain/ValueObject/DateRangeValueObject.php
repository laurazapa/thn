<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\ValueObject;

use Src\Shared\Common\Domain\Exception\InvalidRequestException;

/**
 * Date Range Value Object.
 * 
 * This class represents a range of dates in the domain.
 * It ensures that the start date is before the end date and provides
 * type safety for date range operations.
 */
abstract class DateRangeValueObject
{
    /**
     * Creates a new DateRangeValueObject instance.
     * 
     * @param DateValueObject $startDate The start date of the range
     * @param DateValueObject $endDate The end date of the range
     * @throws InvalidRequestException When start date is not before end date
     */
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

    /**
     * Gets the string representation of the date range.
     * 
     * @return string The date range in format "YYYY-MM-DD,YYYY-MM-DD"
     */
    public function __toString(): string
    {
        return $this->startDate()->value()->format('Y-m-d') . ',' . $this->endDate()->value()->format('Y-m-d');
    }

    /**
     * Gets the start date of the range.
     * 
     * @return DateValueObject The start date
     */
    public function startDate(): DateValueObject
    {
        return $this->startDate;
    }

    /**
     * Gets the end date of the range.
     * 
     * @return DateValueObject The end date
     */
    public function endDate(): DateValueObject
    {
        return $this->endDate;
    }

    /**
     * Validates that the end date is after the start date.
     * 
     * @param DateValueObject $startDate The start date to validate
     * @param DateValueObject $endDate The end date to validate
     * @return bool True if the date range is valid
     */
    public static function isValid(DateValueObject $startDate, DateValueObject $endDate): bool
    {
        return $endDate->value()->gt($startDate->value());
    }
}
