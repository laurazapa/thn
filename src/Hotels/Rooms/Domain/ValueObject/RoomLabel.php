<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\ValueObject;

use Src\Shared\Common\Domain\ValueObject\StringValueObject;

/**
 * Room Label Value Object.
 *
 * This class represents a room's label within its hotel.
 * It extends StringValueObject to ensure the label is a valid string.
 *
 * @extends StringValueObject
 */
final class RoomLabel extends StringValueObject
{
}
