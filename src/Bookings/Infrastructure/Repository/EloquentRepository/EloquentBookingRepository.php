<?php

declare(strict_types=1);

namespace Src\Bookings\Infrastructure\Repository\EloquentRepository;

use Illuminate\Database\Eloquent\Builder;
use Src\Bookings\Domain\Entity\Booking;
use Src\Bookings\Domain\Repository\BookingRepository;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\ValueObject\DateValueObject;

/**
 * Eloquent implementation of the BookingRepository interface.
 * 
 * This class provides the concrete implementation for storing and retrieving
 * bookings using Laravel's Eloquent ORM. It handles the database operations
 * for creating bookings and checking room availability.
 */
class EloquentBookingRepository implements BookingRepository
{
    /**
     * Creates a new booking in the database.
     * 
     * @param Booking $booking The booking to create
     * @return Booking The created booking
     */
    public function create(Booking $booking): Booking
    {
        $booking->save();

        return $booking;
    }

    /**
     * Checks if there is any existing booking for a room in the given date range.
     * The check is done by looking for any booking that overlaps with the given dates.
     * 
     * @param RoomId $roomId The ID of the room to check
     * @param DateValueObject $checkInDate The start date to check
     * @param DateValueObject $checkOutDate The end date to check
     * @return bool True if there is an existing booking, false otherwise
     */
    public function findIfBookingExistsForGivenRoomAndDates(RoomId $roomId, DateValueObject $checkInDate, DateValueObject $checkOutDate): bool
    {
        return $this->query()
            ->where('room_id', '=', $roomId->value())
            ->whereDate('check_in_date', '<', $checkOutDate->value())
            ->whereDate('check_out_date', '>', $checkInDate->value())
            ->exists();
    }

    /**
     * Gets a new query builder instance for the Booking model.
     * 
     * @return Builder The query builder instance
     */
    private function query(): Builder
    {
        return Booking::query();
    }
}
