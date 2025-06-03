<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\UseCase;

use Src\Hotels\Hotels\Application\Request\GetHotelUseCaseRequest;
use Src\Hotels\Hotels\Application\Response\GetHotelUseCaseResponse;
use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\Request\FindHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Service\FindHotelService;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;

/**
 * Use case responsible for retrieving hotel information.
 * This use case orchestrates the retrieval and transformation of hotel data,
 * ensuring proper data access and response formatting.
 */
class GetHotelUseCase
{
    /**
     * Creates a new GetHotelUseCase instance.
     *
     * @param FindHotelService $findHotelService The service for finding hotels
     */
    public function __construct(
        private FindHotelService $findHotelService,
    ) {
    }

    /**
     * Executes the hotel retrieval process.
     *
     * The process follows these steps:
     * 1. Retrieves the hotel using the find hotel service
     * 2. Transforms the hotel entity into a response DTO
     *
     * @param GetHotelUseCaseRequest $request The request containing the hotel identifier
     * @return GetHotelUseCaseResponse Response containing the hotel information
     */
    public function execute(GetHotelUseCaseRequest $request): GetHotelUseCaseResponse
    {
        $hotel = $this->getHotel($request);

        return $this->hotelConverter($hotel);
    }

    /**
     * Retrieves a hotel using the find hotel service.
     *
     * This method:
     * 1. Creates a HotelId value object from the request
     * 2. Executes the find hotel service with room relations
     * 3. Returns the retrieved hotel entity
     *
     * @param GetHotelUseCaseRequest $request The request containing hotel identifier
     * @return Hotel The retrieved hotel entity
     */
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

    /**
     * Converts a hotel entity to a use case response.
     *
     * This method transforms the domain entity into a response DTO by:
     * 1. Extracting all required hotel properties
     * 2. Creating a new response instance with the extracted data
     *
     * @param Hotel $hotel The hotel entity to convert
     * @return GetHotelUseCaseResponse The response containing the needed hotel information
     */
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
