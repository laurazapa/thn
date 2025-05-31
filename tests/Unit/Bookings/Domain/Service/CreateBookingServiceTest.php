<?php

declare(strict_types=1);

namespace Tests\Unit\Bookings\Domain\Service;

use PHPUnit\Framework\MockObject\MockObject;
use Src\Bookings\Domain\Entity\Booking;
use Src\Bookings\Domain\Repository\BookingRepository;
use Src\Bookings\Domain\Request\CreateBookingServiceRequest;
use Src\Bookings\Domain\Response\CreateBookingServiceResponse;
use Src\Bookings\Domain\Service\CreateBookingService;
use Src\Bookings\Domain\ValueObject\BookingId;
use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\Service\UuidGenerator\UuidGenerator;
use Src\Users\Domain\ValueObject\UserId;
use Tests\TestCase;
use Tests\Unit\Shared\Common\Domain\ValueObject\DateMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\IntegerMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

class CreateBookingServiceTest extends TestCase
{
    private CreateBookingService $sut;
    private MockObject $bookingRepository;
    private MockObject $uuidGenerator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookingRepository = $this->createMock(BookingRepository::class);
        $this->uuidGenerator = $this->createMock(UuidGenerator::class);

        $this->sut = new CreateBookingService(
            $this->bookingRepository,
            $this->uuidGenerator
        );
    }

    public function test_when_booking_is_created_then_returns_response_with_booking(): void
    {
        $userId = new UserId(UuidMother::random());
        $roomId = new RoomId(UuidMother::random());
        $hotelId = new HotelId(UuidMother::random());
        $checkInDate = new CheckInDate(DateMother::randomFromToday());
        $carbonCheckOutDate = $checkInDate->value()->addDays(IntegerMother::between(2, 30));
        $checkOutDate = new CheckOutDate($carbonCheckOutDate);
        $bookingId = UuidMother::random();

        $request = new CreateBookingServiceRequest(
            userId: $userId,
            roomId: $roomId,
            hotelId: $hotelId,
            checkInDate: $checkInDate,
            checkOutDate: $checkOutDate
        );

        $booking = new Booking()
            ->setId(new BookingId($bookingId))
            ->setUserId($request->userId())
            ->setRoomId($request->roomId())
            ->setHotelId($request->hotelId())
            ->setCheckInDate($request->checkInDate())
            ->setCheckOutDate($request->checkOutDate());

        $this->uuidGenerator
            ->expects(self::once())
            ->method('generate')
            ->willReturn($bookingId);

        $this->bookingRepository
            ->expects(self::once())
            ->method('create')
            ->willReturn($booking);

        $expected = new CreateBookingServiceResponse($booking);

        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }
}
