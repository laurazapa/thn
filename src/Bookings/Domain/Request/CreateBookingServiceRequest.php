<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Request;

use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Users\Domain\ValueObject\UserId;

/**
 * Request object for creating a new booking.
 * 
 * This class encapsulates all the data required to create a new booking,
 * including user, room, hotel, and date information. It acts as a Data
 * Transfer Object (DTO) for the booking creation process.
 */
class CreateBookingServiceRequest
{
    /**
     * @param UserId $userId The ID of the user making the booking
     * @param RoomId $roomId The ID of the room being booked
     * @param HotelId $hotelId The ID of the hotel where the room is located
     * @param CheckInDate $checkInDate The check-in date
     * @param CheckOutDate $checkOutDate The check-out date
     */
    public function __construct(
        private UserId $userId,
        private RoomId $roomId,
        private HotelId $hotelId,
        private CheckInDate $checkInDate,
        private CheckOutDate $checkOutDate,
    ) {
    }

    /**
     * Gets the user ID.
     * 
     * @return UserId The user's ID
     */
    public function userId(): UserId
    {
        return $this->userId;
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
     * Gets the hotel ID.
     * 
     * @return HotelId The hotel's ID
     */
    public function hotelId(): HotelId
    {
        return $this->hotelId;
    }

    /**
     * Gets the check-in date.
     * 
     * @return CheckInDate The check-in date
     */
    public function checkInDate(): CheckInDate
    {
        return $this->checkInDate;
    }

    /**
     * Gets the check-out date.
     * 
     * @return CheckOutDate The check-out date
     */
    public function checkOutDate(): CheckOutDate
    {
        return $this->checkOutDate;
    }
}
