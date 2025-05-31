<?php

declare(strict_types=1);

namespace Tests\Unit\Hotels\Hotels\Application\UseCase;

use PHPUnit\Framework\MockObject\MockObject;
use Src\Hotels\Hotels\Application\Response\GetHotelUserCountListUseCaseResponse;
use Src\Hotels\Hotels\Application\UseCase\GetHotelUserCountListUseCase;
use Src\Hotels\Hotels\Domain\Response\GetHotelUserCountListServiceResponse;
use Src\Hotels\Hotels\Domain\Service\GetHotelUserCountListService;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;
use Tests\TestCase;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

class GetHotelUserCountListUseCaseTest extends TestCase
{
    private GetHotelUserCountListUseCase $sut;
    private MockObject $getHotelUserCountListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getHotelUserCountListService = $this->createMock(GetHotelUserCountListService::class);

        $this->sut = new GetHotelUserCountListUseCase(
            $this->getHotelUserCountListService,
        );
    }

    public function test_count_unique_users_by_hotel(): void
    {
        $hotel1Id = new HotelId(UuidMother::random());
        $hotel2Id = new HotelId(UuidMother::random());

        $hotel1UserCount = new HotelUserCount(
            id: $hotel1Id->value(),
            users: 2,
        );
        $hotel2UserCount = new HotelUserCount(
            id: $hotel2Id->value(),
            users: 0,
        );
        $repositoryResponse = [$hotel1UserCount, $hotel2UserCount];
        $serviceResponse = new GetHotelUserCountListServiceResponse($repositoryResponse);

        $this->getHotelUserCountListService
            ->expects(self::once())
            ->method('execute')
            ->with()
            ->willReturn($serviceResponse);

        $expected = new GetHotelUserCountListUseCaseResponse($serviceResponse->hotelUserCounts());

        $actual = $this->sut->execute();

        self::assertEquals($expected, $actual);
    }

    public function test_when_there_are_no_hotels_then_returns_empty_list(): void
    {
        $serviceResponse = new GetHotelUserCountListServiceResponse([]);

        $this->getHotelUserCountListService
            ->expects(self::once())
            ->method('execute')
            ->with()
            ->willReturn($serviceResponse);

        $expected = new GetHotelUserCountListUseCaseResponse([]);

        $actual = $this->sut->execute();

        self::assertEquals($expected, $actual);
    }
}
