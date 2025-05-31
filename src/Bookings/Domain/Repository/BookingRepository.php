<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Repository;

use Src\Bookings\Domain\Entity\Booking;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\ValueObject\DateValueObject;

/**
 * Repository interface for managing booking persistence.
 *
 * This interface defines the contract for storing and retrieving bookings
 * from the persistence layer. It provides methods for creating new bookings
 * and checking room availability for specific dates.
 * Note: While it attempts to follow the Repository pattern, the implementation
 * is not fully decoupled from the ORM as the Booking entity extends Eloquent's Model.
 */
interface BookingRepository
{
    /**
     * Creates a new booking in the persistence layer.
     *
     * @param Booking $booking The booking to create
     * @return Booking The created booking with any database-generated values
     */
    public function create(Booking $booking): Booking;

    /**
     * Checks if there is any existing booking for a room in the given date range.
     *
     * @param RoomId $roomId The ID of the room to check
     * @param DateValueObject $checkInDate The start date to check
     * @param DateValueObject $checkOutDate The end date to check
     * @return bool True if there is an existing booking, false otherwise
     */
    public function findIfBookingExistsForGivenRoomAndDates(RoomId $roomId, DateValueObject $checkInDate, DateValueObject $checkOutDate): bool;
}
