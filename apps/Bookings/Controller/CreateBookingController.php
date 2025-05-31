<?php

declare(strict_types=1);

namespace Apps\Bookings\Controller;

use Apps\Bookings\Mapper\CreateBookingRequestMapper;
use Apps\Bookings\Request\CreateBookingControllerRequest;
use Illuminate\Http\JsonResponse;
use Src\Bookings\Application\UseCase\CreateBookingUseCase;

class CreateBookingController
{
    public function __invoke(
        CreateBookingControllerRequest $request,
        CreateBookingRequestMapper $createBookingRequestMapper,
        CreateBookingUseCase $createBookingUseCase,
    ): JsonResponse
    {
        $useCaseRequest = $createBookingRequestMapper->fromRequest($request);

        $response = $createBookingUseCase->execute($useCaseRequest);

        return new JsonResponse(
            $response,
            $response->success() ? 201 : 400
        );
    }
}
