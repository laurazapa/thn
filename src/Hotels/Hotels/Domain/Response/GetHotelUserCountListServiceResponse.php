<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Response;

use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;

class GetHotelUserCountListServiceResponse
{
    /**
     * @param HotelUserCount[] $hotelUserCounts
     */
    public function __construct(
        private array $hotelUserCounts
    ) {
    }

    /**
     * @return HotelUserCount[]
     */
    public function hotelUserCounts(): array
    {
        return $this->hotelUserCounts;
    }
}
