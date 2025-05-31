<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Exception;

use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Src\Shared\Common\Domain\ValueObject\DateValueObject;

/**
 * Exception thrown when attempting to book a room that is already booked for the requested dates.
 * 
 * This exception is thrown during booking validation when there is a date overlap
 * with an existing booking for the same room. It provides detailed information
 * about the conflicting booking period.
 */
class RoomIsAlreadyBookedInTheseDaysException extends InvalidRequestException
{
    /**
     * @param RoomId $roomId The ID of the room being booked
     * @param DateValueObject $checkInDate The requested check-in date
     * @param DateValueObject $checkOutDate The requested check-out date
     */
    public function __construct(RoomId $roomId, DateValueObject $checkInDate, DateValueObject $checkOutDate)
    {
        parent::__construct("Room with id {$roomId->value()} is already booked between {$checkInDate->value()->format('Y-m-d')} and {$checkOutDate->value()->format('Y-m-d')}");
    }
}
