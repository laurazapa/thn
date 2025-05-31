<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Repository;

use Src\Hotels\Rooms\Domain\Entity\Room;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;

/**
 * Room Repository Interface.
 * 
 * This interface defines the contract for room persistence operations.
 * Note: While it attempts to follow the Repository pattern, the implementation
 * is not fully decoupled from the ORM as the Room entity extends Eloquent's Model.
 */
interface RoomRepository
{
    /**
     * Finds a room by its ID.
     * 
     * @param RoomId $roomId The unique identifier of the room to find
     * @param array $relations Optional array of relations to eager load
     * @return Room|null The found room or null if not found
     */
    public function find(RoomId $roomId, array $relations = []): ?Room;
}
