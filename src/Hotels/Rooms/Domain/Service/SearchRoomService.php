<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Service;

use Src\Hotels\Rooms\Domain\Repository\RoomRepository;
use Src\Hotels\Rooms\Domain\Request\SearchRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Response\SearchRoomServiceResponse;

/**
 * Service responsible for searching rooms in the system.
 * 
 * This service provides a low-level interface for room searching,
 * allowing to find rooms by ID and load their relations.
 * It's used by FindRoomService to perform the actual room lookup.
 */
class SearchRoomService
{
    public function __construct(
        private RoomRepository $roomRepository,
    ) {
    }

    /**
     * Searches for a room by its ID and loads the specified relations.
     * 
     * @param SearchRoomServiceRequest $searchRoomServiceRequest The request containing room ID and relations to load
     * @return SearchRoomServiceResponse Response containing the found room (can be null if not found)
     */
    public function execute(SearchRoomServiceRequest $searchRoomServiceRequest): SearchRoomServiceResponse
    {
        $roomId = $searchRoomServiceRequest->roomId();
        $relations = $searchRoomServiceRequest->relations();
        $room = $this->roomRepository->find($roomId, $relations);

        return new SearchRoomServiceResponse($room);
    }
}
