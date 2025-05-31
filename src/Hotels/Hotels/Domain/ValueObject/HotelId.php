<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\ValueObject;

use Src\Shared\Common\Domain\ValueObject\UuidValueObject;

/**
 * Hotel ID Value Object.
 * 
 * This class represents a hotel's unique identifier in the domain.
 * It extends UuidValueObject to ensure that hotel IDs are valid UUIDs
 * and provides type safety for hotel identification.
 */
final class HotelId extends UuidValueObject
{
}
