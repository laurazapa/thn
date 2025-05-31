<?php

declare(strict_types=1);

namespace Src\Users\Domain\ValueObject;

use Src\Shared\Common\Domain\ValueObject\EmailValueObject;

/**
 * User Email Value Object.
 * 
 * This class represents a user's email address.
 * It extends EmailValueObject to ensure the email is valid and properly formatted.
 * 
 * @extends EmailValueObject
 */
final class UserEmail extends EmailValueObject
{
}
