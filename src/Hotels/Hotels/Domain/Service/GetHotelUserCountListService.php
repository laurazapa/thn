<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Service;

use Src\Hotels\Hotels\Domain\Repository\HotelRepository;
use Src\Hotels\Hotels\Domain\Response\GetHotelUserCountListServiceResponse;

/**
 * Get Hotel User Count List Service.
 * 
 * This service is responsible for retrieving the count of unique users per hotel.
 * It uses the hotel repository to fetch the data and returns it in a structured response.
 */
class GetHotelUserCountListService
{
    /**
     * Creates a new GetHotelUserCountListService instance.
     * 
     * @param HotelRepository $hotelRepository The repository for accessing hotel data
     */
    public function __construct(
        private HotelRepository $hotelRepository,
    ) {
    }

    /**
     * Executes the hotel user count list retrieval operation.
     * 
     * The process follows these steps:
     * 1. Retrieves the list of unique users per hotel from the repository
     * 2. Creates and returns a response containing the user count data
     *
     * @return GetHotelUserCountListServiceResponse The response containing the list of hotel user counts
     */
    public function execute(): GetHotelUserCountListServiceResponse
    {
        $hotelUserCountList = $this->hotelRepository->getUniqueUsersPerHotel();

        return new GetHotelUserCountListServiceResponse($hotelUserCountList);
    }
}
