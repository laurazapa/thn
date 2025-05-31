<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\ValueObject;

use Src\Shared\Common\Domain\ValueObject\DateValueObject;

/**
 * Value object that represents a booking's check-in date.
 * 
 * This class extends DateValueObject to provide type safety and
 * domain-specific meaning to check-in dates. It ensures that check-in
 * dates are always valid dates and provides a clear semantic meaning
 * in the domain context.
 */
final class CheckInDate extends DateValueObject
{
}
