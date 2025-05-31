<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Exception;

use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Src\Shared\Common\Domain\ValueObject\DateValueObject;

/**
 * Exception thrown when attempting to create a booking with dates in the past.
 * 
 * This exception is thrown during booking validation when the check-in date
 * is before the current date. It provides detailed information about the
 * invalid booking attempt.
 */
class BookingDatesAreInThePastException extends InvalidRequestException
{
    /**
     * @param RoomId $roomId The ID of the room being booked
     * @param DateValueObject $checkInDate The invalid check-in date
     */
    public function __construct(RoomId $roomId, DateValueObject $checkInDate)
    {
        parent::__construct("Check-in date {$checkInDate->value()->format('Y-m-d')} of room with id {$roomId->value()} is in the past");
    }
}
