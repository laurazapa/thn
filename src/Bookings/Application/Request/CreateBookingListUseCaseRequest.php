<?php

declare(strict_types=1);

namespace Src\Bookings\Application\Request;

class CreateBookingListUseCaseRequest
{
    /**
     * @param BookingItem[] $bookingList
     */
    public function __construct(
        private array $bookingList,
    ) {
    }

    /**
     * @return BookingItem[]
     */
    public function bookingList(): array
    {
        return $this->bookingList;
    }
}
