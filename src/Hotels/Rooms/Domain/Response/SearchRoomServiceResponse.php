<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Response;

use Src\Hotels\Rooms\Domain\Entity\Room;

/**
 * Search Room Service Response.
 * 
 * This class represents the response data from searching for a room.
 * It encapsulates the found room entity, which may be null if no room was found.
 */
class SearchRoomServiceResponse
{
    /**
     * Creates a new SearchRoomServiceResponse instance.
     * 
     * @param Room|null $room The found room entity, or null if no room was found
     */
    public function __construct(
        private ?Room $room = null
    ) {
    }

    /**
     * Gets the found room.
     * 
     * @return Room|null The found room entity, or null if no room was found
     */
    public function room(): ?Room
    {
        return $this->room;
    }
}
