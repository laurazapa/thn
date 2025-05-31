<?php

declare(strict_types=1);

namespace Src\Bookings\Application\Response;

class BookingValidationError
{
    public function __construct(
        private string $message
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
