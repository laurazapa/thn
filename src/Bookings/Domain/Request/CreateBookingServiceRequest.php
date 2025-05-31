<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Request;

use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Users\Domain\ValueObject\UserId;

class CreateBookingServiceRequest
{
    public function __construct(
        private UserId $userId,
        private RoomId $roomId,
        private HotelId $hotelId,
        private CheckInDate $checkInDate,
        private CheckOutDate $checkOutDate,
    ) {
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function roomId(): RoomId
    {
        return $this->roomId;
    }

    public function hotelId(): HotelId
    {
        return $this->hotelId;
    }

    public function checkInDate(): CheckInDate
    {
        return $this->checkInDate;
    }

    public function checkOutDate(): CheckOutDate
    {
        return $this->checkOutDate;
    }
}
