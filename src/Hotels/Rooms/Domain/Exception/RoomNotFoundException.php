<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Exception;

use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\Exception\DataNotFoundException;

class RoomNotFoundException extends DataNotFoundException
{
    public function __construct(RoomId $roomId)
    {
        parent::__construct("Room with id {$roomId->value()} not found");
    }
}
