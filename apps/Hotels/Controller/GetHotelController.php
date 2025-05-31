<?php

declare(strict_types=1);

namespace Apps\Hotels\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Hotels\Hotels\Application\Request\GetHotelUseCaseRequest;
use Src\Hotels\Hotels\Application\UseCase\GetHotelUseCase;

class GetHotelController
{
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
