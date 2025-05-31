<?php

declare(strict_types=1);

namespace Tests\Unit\Hotels\Hotels\Domain\Service;

use PHPUnit\Framework\MockObject\MockObject;
use Src\Hotels\Hotels\Domain\Repository\HotelRepository;
use Src\Hotels\Hotels\Domain\Request\SearchHotelServiceRequest;
use Src\Hotels\Hotels\Domain\Response\SearchHotelServiceResponse;
use Src\Hotels\Hotels\Domain\Service\SearchHotelService;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Tests\TestCase;
use Tests\Unit\Hotels\Hotels\Domain\Entity\HotelMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

class SearchHotelServiceTest extends TestCase
{
    private SearchHotelService $sut;
    private MockObject $hotelRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hotelRepository = $this->createMock(HotelRepository::class);

        $this->sut = new SearchHotelService(
            $this->hotelRepository,
        );
    }

    public function test_when_entity_exists_then_returns_response_with_entity(): void
    {
        $relations = ['rooms'];
        $hotelId = new HotelId(UuidMother::random());
        $request = new SearchHotelServiceRequest($hotelId, $relations);

        $hotel = HotelMother::create(hotelId: $hotelId);

        $this->hotelRepository
            ->expects(self::once())
            ->method('find')
            ->with(
                hotelId: $hotelId,
                relations: $relations
            )
            ->willReturn($hotel);

        $expected = new SearchHotelServiceResponse($hotel);

        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }

    public function test_when_entity_does_not_exist_then_returns_empty_response(): void
    {
        $relations = ['rooms'];
        $hotelId = new HotelId(UuidMother::random());
        $request = new SearchHotelServiceRequest($hotelId, $relations);

        $this->hotelRepository
            ->expects(self::once())
            ->method('find')
            ->with(
                hotelId: $hotelId,
                relations: $relations
            )
            ->willReturn(null);

        $expected = new SearchHotelServiceResponse();

        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }
}
