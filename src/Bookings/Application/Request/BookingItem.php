<?php

namespace Src\Bookings\Application\Request;

class BookingItem
{
    public function __construct(
        private string $userId,
        private string $roomId,
        private string $checkInDate,
        private string $checkOutDate,
    ) {}

    public function userId(): string
    {
        return $this->userId;
    }

    public function roomId(): string
    {
        return $this->roomId;
    }

    public function checkInDate(): string
    {
        return $this->checkInDate;
    }

    public function checkOutDate(): string
    {
        return $this->checkOutDate;
    }
}
