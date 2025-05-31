<?php

declare(strict_types=1);

namespace Src\Bookings\Infrastructure\Repository\EloquentRepository;

use Illuminate\Database\Eloquent\Builder;
use Src\Bookings\Domain\Entity\Booking;
use Src\Bookings\Domain\Repository\BookingRepository;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\ValueObject\DateValueObject;

class EloquentBookingRepository implements BookingRepository
{
    public function create(Booking $booking): Booking
    {
        $booking->save();

        return $booking;
    }

    public function findIfBookingExistsForGivenRoomAndDates(RoomId $roomId, DateValueObject $checkInDate, DateValueObject $checkOutDate): bool
    {
        return $this->query()
            ->where('room_id', '=', $roomId->value())
            ->whereDate('check_in_date', '<', $checkOutDate->value())
            ->whereDate('check_out_date', '>', $checkInDate->value())
            ->exists();
    }

    private function query(): Builder
    {
        return Booking::query();
    }
}
