<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Exception;

use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Src\Shared\Common\Domain\ValueObject\DateValueObject;

class BookingDatesAreInThePastException extends InvalidRequestException
{
    public function __construct(RoomId $roomId, DateValueObject $checkInDate)
    {
        parent::__construct("Check-in date {$checkInDate->value()->format('Y-m-d')} of room with id {$roomId->value()} is in the past");
    }
}
