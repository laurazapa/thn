<?php

declare(strict_types=1);

namespace Apps\Hotels\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Hotels\Hotels\Application\Request\GetHotelUseCaseRequest;
use Src\Hotels\Hotels\Application\UseCase\GetHotelUseCase;

/**
 * Controller responsible for retrieving a specific hotel's information.
 */
class GetHotelController
{
    /**
     * Handles the retrieval of a specific hotel.
     *
     * The flow is:
     * 1. Extracts the hotel UUID from the route parameters
     * 2. Executes the use case to get the hotel information
     * 3. Returns a JSON response with the hotel data
     *
     * @param Request $request The HTTP request containing the hotel UUID in route parameters
     * @param GetHotelUseCase $getHotelUseCase Use case to handle the business logic
     * @return JsonResponse Returns 200 with hotel data on success
     */
    public function __invoke(
        Request $request,
        GetHotelUseCase $getHotelUseCase,
    ): JsonResponse
    {
        $hotelId = (string) $request->route('uuid');

        $response = $getHotelUseCase->execute(
            new GetHotelUseCaseRequest($hotelId)
        );

        return new JsonResponse($response, 200);
    }
}
