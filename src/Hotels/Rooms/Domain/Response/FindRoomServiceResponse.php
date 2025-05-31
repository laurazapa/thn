<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Response;

use Src\Hotels\Rooms\Domain\Entity\Room;

class FindRoomServiceResponse
{
    public function __construct(
        private Room $room
    ) {
    }

    public function room(): Room
    {
        return $this->room;
    }
}
