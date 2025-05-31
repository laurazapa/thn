<?php

declare(strict_types=1);

namespace Tests\Unit\Hotels\Hotels\Application\UseCase;

use PHPUnit\Framework\MockObject\MockObject;
use Src\Hotels\Hotels\Application\Request\GetHotelUseCaseRequest;
use Src\Hotels\Hotels\Application\Response\GetHotelUseCaseResponse;
use Src\Hotels\Hotels\Application\UseCase\GetHotelUseCase;
use Src\Hotels\Hotels\Domain\Request\FindHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Response\FindHotelServiceResponse;
use Src\Hotels\Hotels\Domain\Service\FindHotelService;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Tests\TestCase;
use Tests\Unit\Hotels\Hotels\Domain\Entity\HotelMother;
use Tests\Unit\Hotels\Rooms\Domain\Entity\RoomMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;
use Src\Hotels\Hotels\Domain\Exception\HotelNotFoundException;

class GetHotelUseCaseTest extends TestCase
{
    private GetHotelUseCase $sut;
    private MockObject $findHotelService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->findHotelService = $this->createMock(FindHotelService::class);

        $this->sut = new GetHotelUseCase(
            $this->findHotelService,
        );
    }

    public function test_when_hotel_exists_then_returns_hotel_information(): void
    {
        $room1 = Roommother::create();
        $room2 = Roommother::create();
        $hotelId = new HotelId(UuidMother::random());
        $hotel = HotelMother::create(hotelId: $hotelId)
            ->setRelation('rooms', collect([$room1, $room2]));

        $serviceRequest = new FindHotelServiceRequest(
            hotelId: $hotelId,
            relations: ['rooms']
        );
        $serviceResponse = new FindHotelServiceResponse($hotel);
        $this->findHotelService
            ->expects(self::once())
            ->method('execute')
            ->with($serviceRequest)
            ->willReturn($serviceResponse);

        $expected = new GetHotelUseCaseResponse(
            id: $hotelId->value(),
            name: $hotel->name()->value(),
            city: $hotel->city()->value(),
            country: $hotel->country()->value(),
            numberOfRooms: 2,
        );

        $request = new GetHotelUseCaseRequest($hotelId->value());
        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }

    public function test_when_hotel_does_not_exist_then_throws_exception(): void
    {
        $hotelId = new HotelId(UuidMother::random());

        $serviceRequest = new FindHotelServiceRequest(
            hotelId: $hotelId,
            relations: ['rooms']
        );
        $this->findHotelService
            ->expects(self::once())
            ->method('execute')
            ->with($serviceRequest)
            ->willThrowException(new HotelNotFoundException($hotelId));

        $this->expectException(HotelNotFoundException::class);

        $request = new GetHotelUseCaseRequest($hotelId->value());
        $this->sut->execute($request);
    }
}
