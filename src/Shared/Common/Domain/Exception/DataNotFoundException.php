<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\Exception;

use DomainException;

/**
 * Data Not Found Exception.
 * 
 * This exception is thrown when attempting to access data that doesn't exist.
 * It extends DomainException and is mapped to HTTP 404 responses.
 * 
 * @extends DomainException
 */
class DataNotFoundException extends DomainException
{
}
