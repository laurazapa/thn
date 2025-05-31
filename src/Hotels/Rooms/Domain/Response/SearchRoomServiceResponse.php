<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Response;

use Src\Hotels\Rooms\Domain\Entity\Room;

class SearchRoomServiceResponse
{
    public function __construct(
        private ?Room $room = null
    ) {
    }

    public function room(): ?Room
    {
        return $this->room;
    }
}
