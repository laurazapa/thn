<?php

declare(strict_types=1);

namespace Apps\Hotels\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Hotels\Hotels\Application\UseCase\GetHotelUserCountListUseCase;

/**
 * Controller responsible for retrieving a list of hotels with their user counts.
 */
class GetHotelUserCountListController
{
    /**
     * Handles the retrieval of hotels with their user counts.
     *
     * The flow is:
     * 1. Executes the use case to get the list of hotels with user counts
     * 2. Returns a JSON response with the hotel list data
     *
     * @param Request $request The HTTP request
     * @param GetHotelUserCountListUseCase $getHotelUserCountListUseCase Use case to handle the business logic
     * @return JsonResponse Returns 200 with hotel list data on success
     */
    public function __invoke(
        Request $request,
        GetHotelUserCountListUseCase $getHotelUserCountListUseCase,
    ): JsonResponse
    {
        $response = $getHotelUserCountListUseCase->execute();

        return new JsonResponse($response, 200);
    }
}
