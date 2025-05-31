<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Hotels\Rooms\Domain\Entity\Room;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomLabel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // Hardcoded IDs for documentation purposes
        $rooms = [
            [
                'id' => '4f89e181-935d-4f1b-b72a-dfc34c16fca2',
                'hotel_id' => '9d491317-a39b-4ffd-91fe-9a91a5d21ece',
                'label' => '101',
            ],
            [
                'id' => '7c9e6679-7425-40de-944b-e07fc1f90ae7',
                'hotel_id' => '9d491317-a39b-4ffd-91fe-9a91a5d21ece',
                'label' => '102',
            ],
            [
                'id' => '550e8400-e29b-41d4-a716-446655440000',
                'hotel_id' => '5a69179a-3b9d-4c0e-960d-91649eaab013',
                'label' => 'Suite',
            ]
        ];

        foreach ($rooms as $roomData) {
            $room = new Room();
            $room->setId(new RoomId($roomData['id']));
            $room->setHotelId(new HotelId($roomData['hotel_id']));
            $room->setRoomLabel(new RoomLabel($roomData['label']));
            $room->save();
        }
    }
}
