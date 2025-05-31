<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\Request;

class GetHotelUseCaseRequest
{
    public function __construct(
        private string $hotelId,
    ) {
    }

    public function hotelId(): string
    {
        return $this->hotelId;
    }
}
