<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Service;

use DomainException;
use Src\Hotels\Rooms\Domain\Exception\RoomNotFoundException;
use Src\Hotels\Rooms\Domain\Request\FindRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Request\SearchRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Response\FindRoomServiceResponse;

class FindRoomService
{
    public function __construct(
        private SearchRoomService $searchRoomService,
    ) {
    }

    /**
     * @throws DomainException
     */
    public function execute(FindRoomServiceRequest $findRoomServiceRequest): FindRoomServiceResponse
    {
        $roomId = $findRoomServiceRequest->roomId();
        $room = $this->searchRoomService->execute(
            new SearchRoomServiceRequest($roomId, $findRoomServiceRequest->relations()))
            ->room();

        if ($room === null) {
            throw new RoomNotFoundException($roomId);
        }

        return new FindRoomServiceResponse($room);
    }
}
