<?php

declare(strict_types=1);

namespace Tests\Unit\Hotels\Rooms\Domain\Service;

use PHPUnit\Framework\MockObject\MockObject;
use Src\Hotels\Rooms\Domain\Repository\RoomRepository;
use Src\Hotels\Rooms\Domain\Request\SearchRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Response\SearchRoomServiceResponse;
use Src\Hotels\Rooms\Domain\Service\SearchRoomService;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Tests\TestCase;
use Tests\Unit\Hotels\Rooms\Domain\Entity\RoomMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

/**
 * Test suite for the SearchRoomService.
 * 
 * This test suite verifies the behavior of the SearchRoomService when:
 * - Searching for an existing room with relations
 * - Handling non-existent room scenarios
 * - Proper response formatting for search results
 */
class SearchRoomServiceTest extends TestCase
{
    private SearchRoomService $sut;
    private MockObject $roomRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->roomRepository = $this->createMock(RoomRepository::class);

        $this->sut = new SearchRoomService(
            $this->roomRepository,
        );
    }

    public function test_when_entity_exists_then_returns_response_with_entity(): void
    {
        $relations = [];
        $roomId = new RoomId(UuidMother::random());
        $request = new SearchRoomServiceRequest($roomId, $relations);

        $room = RoomMother::create(roomId: $roomId);

        $this->roomRepository
            ->expects(self::once())
            ->method('find')
            ->with(
                roomId: $roomId,
                relations: $relations
            )
            ->willReturn($room);

        $expected = new SearchRoomServiceResponse($room);

        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }

    public function test_when_entity_does_not_exist_then_returns_empty_response(): void
    {
        $relations = [];
        $roomId = new RoomId(UuidMother::random());
        $request = new SearchRoomServiceRequest($roomId, $relations);

        $this->roomRepository
            ->expects(self::once())
            ->method('find')
            ->with(
                roomId: $roomId,
                relations: $relations
            )
            ->willReturn(null);

        $expected = new SearchRoomServiceResponse();

        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }
}
