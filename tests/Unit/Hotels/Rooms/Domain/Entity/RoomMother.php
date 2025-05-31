<?php

namespace Tests\Unit\Hotels\Rooms\Domain\Entity;

use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\Entity\Room;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomLabel;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\WordMother;

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
