<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Response;

use Src\Hotels\Rooms\Domain\Entity\Room;

/**
 * Find Room Service Response.
 * 
 * This class represents the response data from finding a room.
 * It encapsulates the found room entity.
 */
class FindRoomServiceResponse
{
    /**
     * Creates a new FindRoomServiceResponse instance.
     * 
     * @param Room $room The found room entity
     */
    public function __construct(
        private Room $room
    ) {
    }

    /**
     * Gets the found room.
     * 
     * @return Room The found room entity
     */
    public function room(): Room
    {
        return $this->room;
    }
}
