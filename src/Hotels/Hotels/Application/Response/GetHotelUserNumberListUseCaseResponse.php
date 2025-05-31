<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\Response;

use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;

/**
 * Get Hotel User Number List Use Case Response.
 * 
 * This class represents the response data for retrieving a list of hotel user numbers.
 * It encapsulates an array of hotel user count data.
 */
class GetHotelUserNumberListUseCaseResponse
{
    /**
     * Creates a new GetHotelUserNumberListUseCaseResponse instance.
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
