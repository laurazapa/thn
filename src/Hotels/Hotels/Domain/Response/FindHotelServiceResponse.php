<?php

namespace Src\Hotels\Hotels\Domain\Response;

use Src\Hotels\Hotels\Domain\Entity\Hotel;

class FindHotelServiceResponse
{
    public function __construct(
        private Hotel $hotel
    ) {
    }

    public function hotel(): Hotel
    {
        return $this->hotel;
    }
}
