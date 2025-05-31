<?php

declare(strict_types=1);

namespace Src\Bookings\Application\Response;

/**
 * Value object that represents a single booking validation error.
 * 
 * This class encapsulates an error message that occurred during
 * the validation of a booking request.
 */
class BookingValidationError
{
    /**
     * @param string $message The error message describing the validation failure
     */
    public function __construct(
        private string $message
    ) {
    }

    /**
     * Gets the error message.
     * 
     * @return string The validation error message
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
