<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\UseCase;

use Src\Hotels\Hotels\Application\Response\GetHotelUserCountListUseCaseResponse;
use Src\Hotels\Hotels\Domain\Service\GetHotelUserCountListService;

/**
 * Use case responsible for retrieving a list of hotel user counts.
 * This use case orchestrates the retrieval and transformation of hotel user count data,
 * ensuring proper data access and response formatting.
 */
class GetHotelUserCountListUseCase
{
    /**
     * Creates a new GetHotelUserCountListUseCase instance.
     *
     * @param GetHotelUserCountListService $getHotelUserCountListService The service for getting hotel user counts
     */
    public function __construct(
        private GetHotelUserCountListService $getHotelUserCountListService,
    ) {
    }

    /**
     * Executes the hotel user count list retrieval process.
     *
     * The process follows these steps:
     * 1. Retrieves the list of hotel user counts using a service
     * 2. Transforms the service response into a use case response
     *
     * @return GetHotelUserCountListUseCaseResponse Response containing the list of hotel user counts
     */
    public function execute(): GetHotelUserCountListUseCaseResponse
    {
        $response = $this->getHotelUserCountListService->execute();

        return new GetHotelUserCountListUseCaseResponse(
            $response->hotelUserCounts()
        );
    }
}
