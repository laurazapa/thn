<?php

namespace Src\Bookings\Application\Response;

use JsonSerializable;

class CreateBookingUseCaseResponse implements JsonSerializable
{
    /**
     * @param string[] $bookingIdList
     * @param BookingValidationError[] $errorList
     */
    public function __construct(
        private readonly bool $success,
        private readonly array $bookingIdList = [],
        private readonly array $errorList = []
    ) {
    }

    public function success(): bool
    {
        return $this->success;
    }

    /**
     * @return string[]
     */
    public function bookingIdList(): array
    {
        return $this->bookingIdList;
    }

    /**
     * @return BookingValidationError[]
     */
    public function errorList(): array
    {
        return $this->errorList;
    }

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
