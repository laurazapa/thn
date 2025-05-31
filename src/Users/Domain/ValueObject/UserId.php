<?php

declare(strict_types=1);

namespace Src\Users\Domain\ValueObject;

use Src\Shared\Common\Domain\ValueObject\UuidValueObject;

/**
 * User ID Value Object.
 * 
 * This class represents a user's unique identifier.
 * It extends UuidValueObject to ensure the ID is a valid UUID.
 * 
 * @extends UuidValueObject
 */
final class UserId extends UuidValueObject
{
}
