<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\UseCase;

use Src\Hotels\Hotels\Application\Response\GetHotelUserCountListUseCaseResponse;
use Src\Hotels\Hotels\Domain\Service\GetHotelUserCountListService;

class GetHotelUserCountListUseCase
{
    public function __construct(
        private GetHotelUserCountListService $getHotelUserCountListService,
    ) {
    }

    public function execute(): GetHotelUserCountListUseCaseResponse
    {
        $response = $this->getHotelUserCountListService->execute();

        return new GetHotelUserCountListUseCaseResponse(
            $response->hotelUserCounts()
        );
    }
}
