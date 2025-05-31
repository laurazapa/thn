<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Service;

use DomainException;
use Src\Hotels\Rooms\Domain\Exception\RoomNotFoundException;
use Src\Hotels\Rooms\Domain\Request\FindRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Request\SearchRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Response\FindRoomServiceResponse;

/**
 * Service responsible for finding a specific room by its ID.
 *
 * This service acts as a facade over the SearchRoomService, providing
 * a more specific case for finding a single room. It ensures that
 * the room exists and throws an exception if it doesn't.
 */
class FindRoomService
{
    public function __construct(
        private SearchRoomService $searchRoomService,
    ) {
    }

    /**
     * Finds a room by its ID and returns it with the specified relations.
     *
     * The process:
     * 1. Uses SearchRoomService to look for the room
     * 2. Throws RoomNotFoundException if the room doesn't exist
     * 3. Returns the room with its relations if found
     *
     * @param FindRoomServiceRequest $findRoomServiceRequest The request containing room ID and relations to load
     * @return FindRoomServiceResponse Response containing the found room
     * @throws RoomNotFoundException If the room doesn't exist
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
