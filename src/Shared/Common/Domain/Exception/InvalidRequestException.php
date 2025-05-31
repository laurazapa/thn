<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\Exception;

use DomainException;

/**
 * Invalid Request Exception.
 * 
 * This exception is thrown when a request contains invalid data or
 * doesn't meet the required validation rules. It extends DomainException
 * and is mapped to HTTP 400 responses.
 * 
 * @extends DomainException
 */
class InvalidRequestException extends DomainException
{
}
