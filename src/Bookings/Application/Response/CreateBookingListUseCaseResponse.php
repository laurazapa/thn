<?php

declare(strict_types=1);

namespace Src\Bookings\Application\Response;

use JsonSerializable;

/**
 * Response object for the CreateBookingListUseCase.
 *
 * This class represents the result of attempting to create multiple bookings.
 * It implements JsonSerializable to provide a consistent JSON structure
 * for API responses.
 */
class CreateBookingListUseCaseResponse implements JsonSerializable
{
    /**
     * @param string[] $bookingIdList List of successfully created booking IDs
     * @param BookingValidationError[] $errorList List of validation errors if any
     */
    public function __construct(
        private bool $success,
        private array $bookingIdList = [],
        private array $errorList = []
    ) {
    }

    /**
     * Indicates if the booking creation was successful.
     *
     * @return bool True if all bookings were created successfully
     */
    public function success(): bool
    {
        return $this->success;
    }

    /**
     * Gets the list of created booking IDs.
     *
     * @return string[] Array of booking IDs
     */
    public function bookingIdList(): array
    {
        return $this->bookingIdList;
    }

    /**
     * Gets the list of validation errors.
     *
     * @return BookingValidationError[] Array of validation errors
     */
    public function errorList(): array
    {
        return $this->errorList;
    }

    /**
     * Converts the response to a JSON-serializable array.
     *
     * @return array The response data in array format
     */
    public function jsonSerialize(): array
    {
        return [
            'success' => $this->success,
            'bookingIdList' => $this->bookingIdList,
            'errorList' => array_map(
                fn (BookingValidationError $error) => [
                    'message' => $error->getMessage(),
                ],
                $this->errorList
            ),
        ];
    }
}
