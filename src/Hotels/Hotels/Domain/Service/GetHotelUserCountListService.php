<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Service;

use Src\Hotels\Hotels\Domain\Repository\HotelRepository;
use Src\Hotels\Hotels\Domain\Response\GetHotelUserCountListServiceResponse;

class GetHotelUserCountListService
{
    public function __construct(
        private HotelRepository $hotelRepository,
    ) {
    }

    public function execute(): GetHotelUserCountListServiceResponse
    {
        $hotelUserCountList = $this->hotelRepository->getUniqueUsersPerHotel();

        return new GetHotelUserCountListServiceResponse($hotelUserCountList);
    }
}
