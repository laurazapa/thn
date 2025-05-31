<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Exception;

use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\Exception\DataNotFoundException;

/**
 * Room Not Found Exception.
 * 
 * This exception is thrown when attempting to find a room that doesn't exist.
 * It extends DataNotFoundException to provide a specific error message for room-related operations.
 */
class RoomNotFoundException extends DataNotFoundException
{
    /**
     * Creates a new RoomNotFoundException instance.
     * 
     * @param RoomId $roomId The ID of the room that was not found
     */
    public function __construct(RoomId $roomId)
    {
        parent::__construct("Room with id {$roomId->value()} not found");
    }
}
