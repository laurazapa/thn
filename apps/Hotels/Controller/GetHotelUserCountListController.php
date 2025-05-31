<?php

declare(strict_types=1);

namespace Apps\Hotels\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Hotels\Hotels\Application\UseCase\GetHotelUserCountListUseCase;

class GetHotelUserCountListController
{
    public function __invoke(
        Request $request,
        GetHotelUserCountListUseCase $getHotelUserCountListUseCase,
    ): JsonResponse
    {
        $response = $getHotelUserCountListUseCase->execute();

        return new JsonResponse($response, 200);
    }
}
