<?php

declare(strict_types=1);

namespace Src\Users\Domain\ValueObject;

use Src\Shared\Common\Domain\ValueObject\StringValueObject;

/**
 * User Name Value Object.
 * 
 * This class represents a user's name.
 * It extends StringValueObject to ensure the name is a valid string.
 * 
 * @extends StringValueObject
 */
final class UserName extends StringValueObject
{
}
