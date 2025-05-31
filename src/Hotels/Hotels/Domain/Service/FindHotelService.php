<?php

namespace Src\Hotels\Hotels\Domain\Service;

use DomainException;
use Src\Hotels\Hotels\Domain\Exception\HotelNotFoundException;
use Src\Hotels\Hotels\Domain\Request\FindHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Request\SearchHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Response\FindHotelServiceResponse;

class FindHotelService
{
    public function __construct(
        private SearchHotelService $searchHotelService,
    ) {
    }

    /**
     * @throws DomainException
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
