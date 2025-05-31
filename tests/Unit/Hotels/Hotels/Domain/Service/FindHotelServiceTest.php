<?php

declare(strict_types=1);

namespace Tests\Unit\Hotels\Hotels\Domain\Service;

use PHPUnit\Framework\MockObject\MockObject;
use Src\Hotels\Hotels\Domain\Exception\HotelNotFoundException;
use Src\Hotels\Hotels\Domain\Request\FindHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Request\SearchHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Response\FindHotelServiceResponse;
use Src\Hotels\Hotels\Domain\Response\SearchHotelServiceResponse;
use Src\Hotels\Hotels\Domain\Service\FindHotelService;
use Src\Hotels\Hotels\Domain\Service\SearchHotelService;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Tests\TestCase;
use Tests\Unit\Hotels\Hotels\Domain\Entity\HotelMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

/**
 * Test suite for the FindHotelService.
 *
 * This test suite verifies the behavior of the FindHotelService when:
 * - Finding an existing hotel with relations
 * - Handling non-existent hotel scenarios
 */
class FindHotelServiceTest extends TestCase
{
    private FindHotelService $sut;
    private MockObject $searchHotelService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->searchHotelService = $this->createMock(SearchHotelService::class);

        $this->sut = new FindHotelService(
            $this->searchHotelService,
        );
    }

    public function test_when_entity_exists_then_returns_response_with_entity(): void
    {
        $relations = ['rooms'];
        $hotelId = new HotelId(UuidMother::random());
        $request = new FindHotelServiceRequest($hotelId, $relations);

        $hotel = HotelMother::create(hotelId: $hotelId);

        $this->searchHotelService
            ->expects(self::once())
            ->method('execute')
            ->with(new SearchHotelServiceRequest($hotelId, $relations))
            ->willReturn(new SearchHotelServiceResponse($hotel));

        $expected = new FindHotelServiceResponse($hotel);

        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }

    public function test_when_entity_does_not_exist_then_throws_exception(): void
    {
        $relations = ['rooms'];
        $hotelId = new HotelId(UuidMother::random());
        $request = new FindHotelServiceRequest($hotelId, $relations);

        $this->searchHotelService
            ->expects(self::once())
            ->method('execute')
            ->with(new SearchHotelServiceRequest($hotelId, $relations))
            ->willReturn(new SearchHotelServiceResponse());

        $this->expectException(HotelNotFoundException::class);

        $this->sut->execute($request);
    }
}
