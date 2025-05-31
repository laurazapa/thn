<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\Exception;

use DomainException;

/**
 * Forbidden Request Exception.
 * 
 * This exception is thrown when a user attempts to perform an action
 * they don't have permission for. It extends DomainException and is
 * mapped to HTTP 403 responses.
 * 
 * @extends DomainException
 */
class ForbiddenRequestException extends DomainException
{
}
