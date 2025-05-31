<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Service;

use Src\Hotels\Hotels\Domain\Repository\HotelRepository;
use Src\Hotels\Hotels\Domain\Request\SearchHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Response\SearchHotelServiceResponse;

/**
 * Service responsible for searching hotels in the system.
 * 
 * This service provides a low-level interface for hotel searching,
 * allowing to find hotels by ID and load their relations.
 * It's used by FindHotelService to perform the actual hotel lookup.
 */
class SearchHotelService
{
    public function __construct(
        private HotelRepository $hotelRepository,
    ) {
    }

    /**
     * Searches for a hotel by its ID and loads the specified relations.
     * 
     * @param SearchHotelServiceRequest $searchHotelServiceRequest The request containing hotel ID and relations to load
     * @return SearchHotelServiceResponse Response containing the found hotel (can be null if not found)
     */
    public function execute(SearchHotelServiceRequest $searchHotelServiceRequest): SearchHotelServiceResponse
    {
        $hotelId = $searchHotelServiceRequest->hotelId();
        $relations = $searchHotelServiceRequest->relations();
        $hotel = $this->hotelRepository->find($hotelId, $relations);

        return new SearchHotelServiceResponse($hotel);
    }
}
