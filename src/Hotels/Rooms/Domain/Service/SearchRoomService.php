<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Service;

use Src\Hotels\Rooms\Domain\Repository\RoomRepository;
use Src\Hotels\Rooms\Domain\Request\SearchRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Response\SearchRoomServiceResponse;

class SearchRoomService
{
    public function __construct(
        private RoomRepository $roomRepository,
    ) {
    }

    public function execute(SearchRoomServiceRequest $searchRoomServiceRequest): SearchRoomServiceResponse
    {
        $roomId = $searchRoomServiceRequest->roomId();
        $relations = $searchRoomServiceRequest->relations();
        $room = $this->roomRepository->find($roomId, $relations);

        return new SearchRoomServiceResponse($room);
    }
}
