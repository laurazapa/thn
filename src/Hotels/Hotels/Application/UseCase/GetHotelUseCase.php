<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\UseCase;

use Src\Hotels\Hotels\Application\Request\GetHotelUseCaseRequest;
use Src\Hotels\Hotels\Application\Response\GetHotelUseCaseResponse;
use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\Request\FindHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Service\FindHotelService;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;

class GetHotelUseCase
{
    public function __construct(
        private FindHotelService $findHotelService,
    ) {
    }

    public function execute(GetHotelUseCaseRequest $request): GetHotelUseCaseResponse
    {
        $hotel = $this->getHotel($request);

        return $this->hotelConverter($hotel);
    }

    private function getHotel(GetHotelUseCaseRequest $request): Hotel
    {
        $hotelId = new HotelId($request->hotelId());

        $findHotelResponse = $this->findHotelService->execute(
            new FindHotelServiceRequest(
                hotelId: $hotelId,
                relations: ['rooms']
            ),
        );

        return $findHotelResponse->hotel();
    }

    private function hotelConverter(Hotel $hotel): GetHotelUseCaseResponse
    {
        return new GetHotelUseCaseResponse(
            id: $hotel->id()->value(),
            name: $hotel->name()->value(),
            city: $hotel->city()->value(),
            country: $hotel->country()->value(),
            numberOfRooms: $hotel->numberOfRooms(),
        );
    }
}
