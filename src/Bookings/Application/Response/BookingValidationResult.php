<?php

declare(strict_types=1);

namespace Src\Bookings\Application\Response;

class BookingValidationResult
{
    /**
     * @param BookingValidationError[] $errorList
     */
    public function __construct(
        private array $errorList
    ) {
    }

    public function hasErrors(): bool
    {
        return count($this->errorList) > 0;
    }

    /**
     * @return BookingValidationError[]
     */
    public function getErrors(): array
    {
        return $this->errorList;
    }
}
