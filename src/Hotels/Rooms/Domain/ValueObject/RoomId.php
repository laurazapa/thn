<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\ValueObject;

use Src\Shared\Common\Domain\ValueObject\UuidValueObject;

/**
 * Room ID Value Object.
 * 
 * This class represents a room's unique identifier.
 * It extends UuidValueObject to ensure the ID is a valid UUID.
 * 
 * @extends UuidValueObject
 */
final class RoomId extends UuidValueObject
{
}
