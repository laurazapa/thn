<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\ValueObject;

use Src\Shared\Common\Domain\ValueObject\DateRangeValueObject;

/**
 * Value object that represents a booking's date range.
 * 
 * This class extends DateRangeValueObject to provide type safety and
 * domain-specific meaning to booking date ranges. It encapsulates both
 * the check-in and check-out dates in a single value object.
 */
final class CheckInCheckOutDateRange extends DateRangeValueObject
{
}
