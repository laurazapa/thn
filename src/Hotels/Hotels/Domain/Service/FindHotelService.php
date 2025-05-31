<?php

namespace Src\Hotels\Hotels\Domain\Service;

use DomainException;
use Src\Hotels\Hotels\Domain\Exception\HotelNotFoundException;
use Src\Hotels\Hotels\Domain\Request\FindHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Request\SearchHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Response\FindHotelServiceResponse;

/**
 * Service responsible for finding a specific hotel by its ID.
 *
 * This service acts as a facade over the SearchHotelService, providing
 * a more specific case for finding a single hotel. It ensures that
 * the hotel exists and throws an exception if it doesn't.
 */
class FindHotelService
{
    /**
     * Creates a new FindHotelService instance.
     *
     * @param SearchHotelService $searchHotelService The service for searching hotels
     */
    public function __construct(
        private SearchHotelService $searchHotelService,
    ) {
    }

    /**
     * Finds a hotel by its ID and returns it with the specified relations.
     *
     * The process:
     * 1. Uses SearchHotelService to look for the hotel
     * 2. Throws HotelNotFoundException if the hotel doesn't exist
     * 3. Returns the hotel with its relations if found
     *
     * @param FindHotelServiceRequest $findHotelServiceRequest The request containing hotel ID and relations to load
     * @return FindHotelServiceResponse Response containing the found hotel
     * @throws HotelNotFoundException If the hotel doesn't exist
     */
    public function execute(FindHotelServiceRequest $findHotelServiceRequest): FindHotelServiceResponse
    {
        $hotelId = $findHotelServiceRequest->hotelId();
        $hotel = $this->searchHotelService->execute(
            new SearchHotelServiceRequest($hotelId, $findHotelServiceRequest->relations()))
            ->hotel();

        if ($hotel === null) {
            throw new HotelNotFoundException($hotelId);
        }

        return new FindHotelServiceResponse($hotel);
    }

}
