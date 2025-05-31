<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Response;

use Src\Hotels\Hotels\Domain\Entity\Hotel;

class SearchHotelServiceResponse
{
    public function __construct(
        private ?Hotel $hotel = null
    ) {
    }

    public function hotel(): ?Hotel
    {
        return $this->hotel;
    }
}
