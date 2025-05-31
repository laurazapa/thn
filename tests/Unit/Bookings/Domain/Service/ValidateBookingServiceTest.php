<?php

declare(strict_types=1);

namespace Tests\Unit\Bookings\Domain\Service;

use Carbon\Carbon;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Bookings\Domain\Exception\BookingDatesAreInThePastException;
use Src\Bookings\Domain\Exception\RoomIsAlreadyBookedInTheseDaysException;
use Src\Bookings\Domain\Repository\BookingRepository;
use Src\Bookings\Domain\Request\ValidateBookingServiceRequest;
use Src\Bookings\Domain\Service\ValidateBookingService;
use Src\Bookings\Domain\ValueObject\CheckInCheckOutDateRange;
use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Tests\TestCase;
use Tests\Unit\Shared\Common\Domain\ValueObject\DateMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\IntegerMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

class ValidateBookingServiceTest extends TestCase
{
    private ValidateBookingService $sut;
    private MockObject $bookingRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookingRepository = $this->createMock(BookingRepository::class);

        $this->sut = new ValidateBookingService(
            $this->bookingRepository,
        );
    }

    public function test_when_dates_are_valid_and_room_is_available_then_does_not_throw_exception(): void
    {
        $roomId = new RoomId(UuidMother::random());
        $checkInDate = new CheckInDate(DateMother::randomFromToday());
        $carbonCheckOutDate = $checkInDate->value()->clone()->addDays(IntegerMother::between(2, 30));
        $checkOutDate = new CheckOutDate($carbonCheckOutDate);
        $checkInCheckOutDateRange = new CheckInCheckOutDateRange($checkInDate, $checkOutDate);

        $request = new ValidateBookingServiceRequest(
            roomId: $roomId,
            checkInCheckOutDateRange: $checkInCheckOutDateRange,
        );

        $this->bookingRepository
            ->expects(self::once())
            ->method('findIfBookingExistsForGivenRoomAndDates')
            ->with($roomId, $checkInDate, $checkOutDate)
            ->willReturn(false);

        $this->sut->execute($request);
    }

    public function test_when_check_in_date_is_in_the_past_then_throws_exception(): void
    {
        $roomId = new RoomId(UuidMother::random());
        $checkInDate = new CheckInDate(Carbon::yesterday());
        $checkOutDate = new CheckOutDate(Carbon::today());
        $checkInCheckOutDateRange = new CheckInCheckOutDateRange($checkInDate, $checkOutDate);

        $request = new ValidateBookingServiceRequest(
            roomId: $roomId,
            checkInCheckOutDateRange: $checkInCheckOutDateRange,
        );

        $this->expectException(BookingDatesAreInThePastException::class);

        $this->sut->execute($request);
    }

    public function test_when_room_is_already_booked_then_throws_exception(): void
    {
        $roomId = new RoomId(UuidMother::random());
        $checkInDate = new CheckInDate(DateMother::randomFromToday());
        $carbonCheckOutDate = $checkInDate->value()->clone()->addDays(IntegerMother::between(2, 30));
        $checkOutDate = new CheckOutDate($carbonCheckOutDate);
        $checkInCheckOutDateRange = new CheckInCheckOutDateRange($checkInDate, $checkOutDate);

        $request = new ValidateBookingServiceRequest(
            roomId: $roomId,
            checkInCheckOutDateRange: $checkInCheckOutDateRange,
        );

        $this->bookingRepository
            ->expects(self::once())
            ->method('findIfBookingExistsForGivenRoomAndDates')
            ->with($roomId, $checkInDate, $checkOutDate)
            ->willReturn(true);

        $this->expectException(RoomIsAlreadyBookedInTheseDaysException::class);

        $this->sut->execute($request);
    }
}
