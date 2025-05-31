<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Request;

use Src\Hotels\Rooms\Domain\ValueObject\RoomId;

/**
 * Search Room Service Request.
 * 
 * This class represents the request data needed to search for a room.
 * It encapsulates the room ID and any relations that should be eager loaded.
 */
class SearchRoomServiceRequest
{
    /**
     * Creates a new SearchRoomServiceRequest instance.
     * 
     * @param RoomId $roomId The unique identifier of the room to search
     * @param array $relations Optional array of relations to eager load
     */
    public function __construct(
        private RoomId $roomId,
        private array $relations = [],
    ) {
    }

    /**
     * Gets the room ID.
     * 
     * @return RoomId The unique identifier of the room to search
     */
    public function roomId(): RoomId
    {
        return $this->roomId;
    }

    /**
     * Gets the relations to eager load.
     * 
     * @return string[] Array of relation names to eager load
     */
    public function relations(): array
    {
        return $this->relations;
    }
}
