<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Request;

use Src\Hotels\Rooms\Domain\ValueObject\RoomId;

class SearchRoomServiceRequest
{
    public function __construct(
        private RoomId $roomId,
        private array $relations = [],
    ) {
    }

    public function roomId(): RoomId
    {
        return $this->roomId;
    }

    /**
     * @return string[] array
     */
    public function relations(): array
    {
        return $this->relations;
    }
}
