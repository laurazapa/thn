<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Repository;

use Src\Hotels\Rooms\Domain\Entity\Room;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;

interface RoomRepository
{
    public function find(RoomId $roomId, array $relations = []): ?Room;
}
