<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Request;

use Src\Bookings\Domain\ValueObject\CheckInCheckOutDateRange;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;

class ValidateBookingServiceRequest
{
    public function __construct(
        private RoomId $roomId,
        private CheckInCheckOutDateRange $checkInCheckOutDateRange,
    ) {
    }

    public function roomId(): RoomId
    {
        return $this->roomId;
    }

    public function checkInCheckOutDateRange(): CheckInCheckOutDateRange
    {
        return $this->checkInCheckOutDateRange;
    }
}
