<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Service;

use Src\Hotels\Hotels\Domain\Repository\HotelRepository;
use Src\Hotels\Hotels\Domain\Request\SearchHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Response\SearchHotelServiceResponse;

class SearchHotelService
{
    public function __construct(
        private HotelRepository $hotelRepository,
    ) {
    }

    public function execute(SearchHotelServiceRequest $searchHotelServiceRequest): SearchHotelServiceResponse
    {
        $hotelId = $searchHotelServiceRequest->hotelId();
        $relations = $searchHotelServiceRequest->relations();
        $hotel = $this->hotelRepository->find($hotelId, $relations);

        return new SearchHotelServiceResponse($hotel);
    }
}
