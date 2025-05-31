<?php

declare(strict_types=1);

namespace Tests\Unit\Hotels\Rooms\Domain\Service;

use PHPUnit\Framework\MockObject\MockObject;
use Src\Hotels\Rooms\Domain\Exception\RoomNotFoundException;
use Src\Hotels\Rooms\Domain\Request\FindRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Request\SearchRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Response\FindRoomServiceResponse;
use Src\Hotels\Rooms\Domain\Response\SearchRoomServiceResponse;
use Src\Hotels\Rooms\Domain\Service\FindRoomService;
use Src\Hotels\Rooms\Domain\Service\SearchRoomService;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Tests\TestCase;
use Tests\Unit\Hotels\Rooms\Domain\Entity\RoomMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

class FindRoomServiceTest extends TestCase
{
    private FindRoomService $sut;
    private MockObject $searchRoomService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->searchRoomService = $this->createMock(SearchRoomService::class);

        $this->sut = new FindRoomService(
            $this->searchRoomService,
        );
    }

    public function test_when_entity_exists_then_returns_response_with_entity(): void
    {
        $relations = [];
        $roomId = new RoomId(UuidMother::random());
        $request = new FindRoomServiceRequest($roomId, $relations);

        $room = RoomMother::create(roomId: $roomId);

        $this->searchRoomService
            ->expects(self::once())
            ->method('execute')
            ->with(new SearchRoomServiceRequest($roomId, $relations))
            ->willReturn(new SearchRoomServiceResponse($room));

        $expected = new FindRoomServiceResponse($room);

        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }

    public function test_when_entity_does_not_exist_then_throws_exception(): void
    {
        $relations = [];
        $roomId = new RoomId(UuidMother::random());
        $request = new FindRoomServiceRequest($roomId, $relations);

        $this->searchRoomService
            ->expects(self::once())
            ->method('execute')
            ->with(new SearchRoomServiceRequest($roomId, $relations))
            ->willReturn(new SearchRoomServiceResponse());

        $this->expectException(RoomNotFoundException::class);

        $this->sut->execute($request);
    }
}
