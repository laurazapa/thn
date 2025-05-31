<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Response;

use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;

/**
 * Get Hotel User Count List Service Response.
 * 
 * This class represents the response data from a hotel user count list operation.
 * It encapsulates an array of hotel user count data.
 */
class GetHotelUserCountListServiceResponse
{
    /**
     * Creates a new GetHotelUserCountListServiceResponse instance.
     * 
     * @param HotelUserCount[] $hotelUserCounts Array of hotel user count data
     */
    public function __construct(
        private array $hotelUserCounts
    ) {
    }

    /**
     * Gets the list of hotel user counts.
     * 
     * @return HotelUserCount[] Array of hotel user count data
     */
    public function hotelUserCounts(): array
    {
        return $this->hotelUserCounts;
    }
}
