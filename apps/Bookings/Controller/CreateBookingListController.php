<?php

declare(strict_types=1);

namespace Apps\Bookings\Controller;

use Apps\Bookings\Mapper\CreateBookingListRequestMapper;
use Apps\Bookings\Request\CreateBookingListControllerRequest;
use Illuminate\Http\JsonResponse;
use Src\Bookings\Application\UseCase\CreateBookingListUseCase;

/**
 * Controller responsible for handling the creation of multiple bookings in a single request.
 */
class CreateBookingListController
{
    /**
     * Handles the creation of multiple bookings.
     *
     * The flow is:
     * 1. Receives the request and maps it to a use case request
     * 2. Executes the use case to create the bookings
     * 3. Returns a JSON response with the result
     *
     * @param CreateBookingListControllerRequest $request The HTTP request containing booking data
     * @param CreateBookingListRequestMapper $createBookingListRequestMapper Mapper to transform the request
     * @param CreateBookingListUseCase $createBookingListUseCase Use case to handle the business logic
     * @return JsonResponse Returns 201 on success, 400 on failure
     */
    public function __invoke(
        CreateBookingListControllerRequest $request,
        CreateBookingListRequestMapper $createBookingListRequestMapper,
        CreateBookingListUseCase $createBookingListUseCase,
    ): JsonResponse
    {
        $useCaseRequest = $createBookingListRequestMapper->fromRequest($request);

        $response = $createBookingListUseCase->execute($useCaseRequest);

        return new JsonResponse(
            $response,
            $response->success() ? 201 : 400
        );
    }
}
