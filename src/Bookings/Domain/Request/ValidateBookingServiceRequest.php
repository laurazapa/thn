<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Request;

use Src\Bookings\Domain\ValueObject\CheckInCheckOutDateRange;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;

/**
 * Request object for validating a booking.
 * 
 * This class encapsulates the data required to validate a booking request,
 * including the room ID and the date range for the booking. It acts as a
 * Data Transfer Object (DTO) for the booking validation process.
 */
class ValidateBookingServiceRequest
{
    /**
     * @param RoomId $roomId The ID of the room to validate
     * @param CheckInCheckOutDateRange $checkInCheckOutDateRange The date range to validate
     */
    public function __construct(
        private RoomId $roomId,
        private CheckInCheckOutDateRange $checkInCheckOutDateRange,
    ) {
    }

    /**
     * Gets the room ID.
     * 
     * @return RoomId The room's ID
     */
    public function roomId(): RoomId
    {
        return $this->roomId;
    }

    /**
     * Gets the check-in and check-out date range.
     * 
     * @return CheckInCheckOutDateRange The date range
     */
    public function checkInCheckOutDateRange(): CheckInCheckOutDateRange
    {
        return $this->checkInCheckOutDateRange;
    }
}
