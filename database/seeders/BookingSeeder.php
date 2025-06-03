<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Src\Bookings\Domain\Entity\Booking;
use Src\Bookings\Domain\ValueObject\BookingId;
use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Users\Domain\ValueObject\UserId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Hardcoded IDs for documentation purposes
        $userIds = [
            '9d491317-a39b-4ffd-91fe-9a91a5d21ece', // Voldemort
            '5a69179a-3b9d-4c0e-960d-91649eaab013', // Nagini
        ];

        $roomIds = [
            '4f89e181-935d-4f1b-b72a-dfc34c16fca2', // Room 101
            '7c9e6679-7425-40de-944b-e07fc1f90ae7', // Room 102
            '550e8400-e29b-41d4-a716-446655440000', // Suite
        ];

        $hotelIds = [
            '9d491317-a39b-4ffd-91fe-9a91a5d21ece', // Pramana Watu Kurung
            '5a69179a-3b9d-4c0e-960d-91649eaab013', // El racó de Madremanya
        ];

        // Create some example bookings
        for ($i = 0; $i < 5; $i++) {
            $booking = new Booking();
            $booking->setId(new BookingId(UuidMother::random()));
            $booking->setUserId(new UserId($userIds[array_rand($userIds)]));
            $booking->setRoomId(new RoomId($roomIds[array_rand($roomIds)]));
            $booking->setHotelId(new HotelId($hotelIds[array_rand($hotelIds)]));

            // Random dates for the next 30 days
            $checkIn = Carbon::now()->addDays(rand(1, 15));
            $checkOut = $checkIn->copy()->addDays(rand(1, 5));

            $booking->setCheckInDate(new CheckInDate($checkIn));
            $booking->setCheckOutDate(new CheckOutDate($checkOut));

            $booking->save();
        }
    }
}
