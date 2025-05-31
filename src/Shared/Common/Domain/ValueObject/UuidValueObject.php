<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;

/**
 * UUID Value Object.
 * 
 * This class represents a UUID value in the domain.
 * It provides validation and type safety for UUID values using
 * the Ramsey UUID library.
 */
abstract class UuidValueObject
{
    /**
     * Creates a new UuidValueObject instance.
     * 
     * @param string $value The UUID string value
     * @throws InvalidRequestException When the value is not a valid UUID
     */
    public function __construct(private string $value)
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidRequestException(sprintf('<%s> does not allow the value <%s>.', self::class, $value));
        }
    }

    /**
     * Gets the string representation of the UUID.
     * 
     * @return string The UUID string
     */
    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * Gets the UUID value.
     * 
     * @return string The UUID string
     */
    public function value(): string
    {
        return $this->value;
    }
}
