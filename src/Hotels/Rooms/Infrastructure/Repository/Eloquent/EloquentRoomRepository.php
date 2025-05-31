<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Infrastructure\Repository\Eloquent;

use Src\Hotels\Rooms\Domain\Entity\Room;
use Src\Hotels\Rooms\Domain\Repository\RoomRepository;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;

class EloquentRoomRepository implements RoomRepository
{
    public function find(RoomId $roomId, array $relations = []): ?Room
    {
        return Room::query()
            ->with($relations)
            ->find($roomId->value());
    }
}
