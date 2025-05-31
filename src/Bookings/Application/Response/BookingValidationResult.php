<?php

declare(strict_types=1);

namespace Src\Bookings\Application\Response;

/**
 * Value object that contains the result of a booking validation process.
 * 
 * This class holds a list of validation errors that occurred during the
 * validation of one or more bookings. It provides methods to check if
 * there were any errors and to retrieve them.
 */
class BookingValidationResult
{
    /**
     * @param BookingValidationError[] $errorList List of validation errors found
     */
    public function __construct(
        private array $errorList
    ) {
    }

    /**
     * Checks if there are any validation errors.
     * 
     * @return bool True if there are errors, false otherwise
     */
    public function hasErrors(): bool
    {
        return count($this->errorList) > 0;
    }

    /**
     * Gets the list of validation errors.
     * 
     * @return BookingValidationError[] Array of validation errors
     */
    public function getErrors(): array
    {
        return $this->errorList;
    }
}
