<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Response;

use Src\Bookings\Domain\Entity\Booking;

class CreateBookingServiceResponse
{
    public function __construct(
        private Booking $booking
    ) {
    }

    public function booking(): Booking
    {
        return $this->booking;
    }
}
