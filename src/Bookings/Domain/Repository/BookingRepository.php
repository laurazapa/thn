<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Repository;

use Src\Bookings\Domain\Entity\Booking;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\ValueObject\DateValueObject;

interface BookingRepository
{
    public function create(Booking $booking): Booking;

    public function findIfBookingExistsForGivenRoomAndDates(RoomId $roomId, DateValueObject $checkInDate, DateValueObject $checkOutDate): bool;
}
