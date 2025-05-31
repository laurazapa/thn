<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Exception;

use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Src\Shared\Common\Domain\ValueObject\DateValueObject;

class RoomIsAlreadyBookedInTheseDaysException extends InvalidRequestException
{
    public function __construct(RoomId $roomId, DateValueObject $checkInDate, DateValueObject $checkOutDate)
    {
        parent::__construct("Room with id {$roomId->value()} is already booked between {$checkInDate->value()->format('Y-m-d')} and {$checkOutDate->value()->format('Y-m-d')}");
    }
}
