<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\ValueObject;

use Src\Shared\Common\Domain\ValueObject\UuidValueObject;

/**
 * Value object that represents a booking's unique identifier.
 * 
 * This class extends UuidValueObject to provide type safety and
 * domain-specific meaning to booking IDs. It ensures that booking
 * IDs are always valid UUIDs.
 */
final class BookingId extends UuidValueObject
{
}
