<?php

namespace Tests\Unit\Bookings\Domain\Entity;

use Src\Bookings\Domain\Entity\Booking;
use Src\Bookings\Domain\ValueObject\BookingId;
use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Users\Domain\ValueObject\UserId;
use Tests\Unit\Shared\Common\Domain\ValueObject\DateMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\IntegerMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

class BookingMother
{
    public static function create(
        ?BookingId $bookingId = null,
        ?UserId $userId = null,
        ?RoomId $roomId = null,
        ?HotelId $hotelId = null,
        ?CheckInDate $checkInDate = null,
        ?CheckOutDate $checkOutDate = null,
    ): Booking {
        $checkInDate = $checkInDate ?? DateMother::randomFromToday();
        $checkOutDate = $checkOutDate ?? $checkInDate->value()->clone()->addDays(IntegerMother::between(2, 30));

        return new Booking()
            ->setId($bookingId ?? new BookingId(UuidMother::random()))
            ->setUserId($userId ?? new UserId(UuidMother::random()))
            ->setRoomId($roomId ?? new RoomId(UuidMother::random()))
            ->setHotelId($hotelId ?? new HotelId(UuidMother::random()))
            ->setCheckInDate($checkInDate)
            ->setCheckOutDate($checkOutDate);
    }
}
