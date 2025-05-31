<?php

declare(strict_types=1);

namespace Tests\Unit\Hotels\Hotels\Domain\Service;

use PHPUnit\Framework\MockObject\MockObject;
use Src\Hotels\Hotels\Domain\Repository\HotelRepository;
use Src\Hotels\Hotels\Domain\Response\GetHotelUserCountListServiceResponse;
use Src\Hotels\Hotels\Domain\Service\GetHotelUserCountListService;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;
use Tests\TestCase;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

/**
 * Test suite for the GetHotelUserCountListService.
 * 
 * This test suite verifies the behavior of the GetHotelUserCountListService when:
 * - Counting unique users per hotel
 * - Handling scenarios with no hotels
 * - Proper response formatting with user counts
 */
class GetHotelUserCountListServiceTest extends TestCase
{
    private GetHotelUserCountListService $sut;
    private MockObject $hotelRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hotelRepository = $this->createMock(HotelRepository::class);

        $this->sut = new GetHotelUserCountListService(
            $this->hotelRepository,
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
        $this->hotelRepository
            ->expects(self::once())
            ->method('getUniqueUsersPerHotel')
            ->with()
            ->willReturn($repositoryResponse);

        $expected = new GetHotelUserCountListServiceResponse($repositoryResponse);

        $actual = $this->sut->execute();

        self::assertEquals($expected, $actual);
    }

    public function test_when_there_are_no_hotels_then_returns_empty_list(): void
    {
        $this->hotelRepository
            ->expects(self::once())
            ->method('getUniqueUsersPerHotel')
            ->with()
            ->willReturn([]);

        $expected = new GetHotelUserCountListServiceResponse([]);

        $actual = $this->sut->execute();

        self::assertEquals($expected, $actual);
    }
}
