<?php

namespace Tests\Unit\Hotels\Rooms\Domain\Entity;

use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\Entity\Room;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomLabel;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\WordMother;

/**
 * Factory class for creating Room test instances.
 * 
 * This class provides methods to create Room entities with random or specific values
 * for testing purposes. It ensures consistent test data generation across the test suite.
 */
class RoomMother
{
    public static function create(
        ?RoomId $roomId = null,
        ?HotelId $hotelId = null,
        ?RoomLabel $roomLabel = null,
    ): Room {
        return new Room()
            ->setId($roomId ?? new RoomId(UuidMother::random()))
            ->setHotelId($hotelId ?? new HotelId(UuidMother::random()))
            ->setRoomLabel($roomLabel ?? new RoomLabel(WordMother::random()));
    }
}
