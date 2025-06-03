<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Infrastructure\Repository\Eloquent;

use Src\Hotels\Rooms\Domain\Entity\Room;
use Src\Hotels\Rooms\Domain\Repository\RoomRepository;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;

/**
 * Eloquent Room Repository Implementation.
 *
 * This class implements the RoomRepository interface using Laravel's Eloquent ORM.
 * It provides concrete implementations for room operations.
 */
class EloquentRoomRepository implements RoomRepository
{
    /**
     * Finds a room by its ID using Eloquent ORM.
     *
     * @param RoomId $roomId The unique identifier of the room to find
     * @param array $relations Optional array of relations to eager load
     * @return Room|null The found room or null if not found
     */
    public function find(RoomId $roomId, array $relations = []): ?Room
    {
        return Room::query()
            ->with($relations)
            ->find($roomId->value());
    }
}
