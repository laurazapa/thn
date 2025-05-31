<?php

declare(strict_types=1);

namespace Tests\Unit\Bookings\Application\UseCase;

use PHPUnit\Framework\MockObject\MockObject;
use Src\Bookings\Application\Request\BookingItem;
use Src\Bookings\Application\Request\CreateBookingListUseCaseRequest;
use Src\Bookings\Application\Response\BookingValidationError;
use Src\Bookings\Application\Response\CreateBookingListUseCaseResponse;
use Src\Bookings\Application\UseCase\CreateBookingListUseCase;
use Src\Bookings\Domain\Exception\BookingDatesAreInThePastException;
use Src\Bookings\Domain\Exception\RoomIsAlreadyBookedInTheseDaysException;
use Src\Bookings\Domain\Request\CreateBookingServiceRequest;
use Src\Bookings\Domain\Request\ValidateBookingServiceRequest;
use Src\Bookings\Domain\Response\CreateBookingServiceResponse;
use Src\Bookings\Domain\Service\CreateBookingService;
use Src\Bookings\Domain\Service\ValidateBookingService;
use Src\Bookings\Domain\ValueObject\CheckInCheckOutDateRange;
use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\Exception\RoomNotFoundException;
use Src\Hotels\Rooms\Domain\Request\FindRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Response\FindRoomServiceResponse;
use Src\Hotels\Rooms\Domain\Service\FindRoomService;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\Transaction\TransactionManager;
use Src\Users\Domain\ValueObject\UserId;
use Tests\TestCase;
use Tests\Unit\Bookings\Domain\Entity\BookingMother;
use Tests\Unit\Hotels\Rooms\Domain\Entity\RoomMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\DateMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\IntegerMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;

/**
 * Test suite for the CreateBookingListUseCase.
 * 
 * This test suite verifies the behavior of the CreateBookingListUseCase when:
 * - All bookings in the list are valid and can be created
 * - Some bookings fail validation and return appropriate errors
 * - Room does not exist and throws appropriate exception
 */
class CreateBookingListUseCaseTest extends TestCase
{
    private CreateBookingListUseCase $sut;
    private MockObject $validateBookingService;
    private MockObject $createBookingService;
    private MockObject $findRoomService;
    private MockObject $transactionManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validateBookingService = $this->createMock(ValidateBookingService::class);
        $this->createBookingService = $this->createMock(CreateBookingService::class);
        $this->findRoomService = $this->createMock(FindRoomService::class);
        $this->transactionManager = $this->createMock(TransactionManager::class);

        $this->sut = new CreateBookingListUseCase(
            $this->validateBookingService,
            $this->createBookingService,
            $this->findRoomService,
            $this->transactionManager,
        );
    }

    public function test_when_all_bookings_are_valid_then_creates_all_bookings(): void
    {
        $userId = UuidMother::random();
        $roomId = UuidMother::random();
        $roomIdVO = new RoomId($roomId);
        $hotelId = UuidMother::random();
        $hotelIdVO = new HotelId($hotelId);
        $checkInDate = new CheckInDate(DateMother::randomFromToday());
        $carbonCheckOutDate = $checkInDate->value()->clone()->addDays(IntegerMother::between(2, 30));
        $checkOutDate = new CheckOutDate($carbonCheckOutDate);
        $checkInCheckOutDateRange = new CheckInCheckOutDateRange($checkInDate, $checkOutDate);

        $bookingItem = new BookingItem(
            userId: $userId,
            roomId: $roomId,
            checkInDate: $checkInDate->value()->toDateString(),
            checkOutDate: $checkOutDate->value()->toDateString(),
        );

        $request = new CreateBookingListUseCaseRequest([$bookingItem]);

        $room = RoomMother::create(
            roomId: $roomIdVO,
            hotelId: $hotelIdVO,
        );

        $booking = BookingMother::create(
            userId: new UserId($userId),
            roomId: $roomIdVO,
            hotelId: $hotelIdVO,
            checkInDate: $checkInDate,
            checkOutDate: $checkOutDate
        );

        $validateServiceRequest = new ValidateBookingServiceRequest(
            roomId: $roomIdVO,
            checkInCheckOutDateRange: $checkInCheckOutDateRange,
        );
        $this->validateBookingService
            ->expects(self::once())
            ->method('execute')
            ->with($validateServiceRequest);

        $this->transactionManager
            ->expects(self::once())
            ->method('execute')
            ->willReturnCallback(function (callable $callback) {
                return $callback();
            });

        $this->findRoomService
            ->expects(self::once())
            ->method('execute')
            ->with(new FindRoomServiceRequest($roomIdVO))
            ->willReturn(new FindRoomServiceResponse($room));

        $createServiceRequest = new CreateBookingServiceRequest(
            userId: new UserId($bookingItem->userId()),
            roomId: $roomIdVO,
            hotelId: $hotelIdVO,
            checkInDate: $checkInDate,
            checkOutDate: $checkOutDate,
        );
        $this->createBookingService
            ->expects(self::once())
            ->method('execute')
            ->with($createServiceRequest)
            ->willReturn(new CreateBookingServiceResponse($booking));

        $expected = new CreateBookingListUseCaseResponse(
            success: true,
            bookingIdList: [$booking->id()->value()]
        );

        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }

    public function test_when_booking_validation_fails_then_returns_validation_errors(): void
    {
        $userId = UuidMother::random();
        $roomId = UuidMother::random();
        $roomIdVO = new RoomId($roomId);
        $checkInDate = new CheckInDate(DateMother::randomFromToday());
        $carbonCheckOutDate = $checkInDate->value()->clone()->addDays(IntegerMother::between(2, 30));
        $checkOutDate = new CheckOutDate($carbonCheckOutDate);
        $checkInCheckOutDateRange = new CheckInCheckOutDateRange($checkInDate, $checkOutDate);

        $bookingItem = new BookingItem(
            userId: $userId,
            roomId: $roomId,
            checkInDate: $checkInDate->value()->toDateString(),
            checkOutDate: $checkOutDate->value()->toDateString(),
        );

        $request = new CreateBookingListUseCaseRequest([$bookingItem]);

        $validateServiceRequest = new ValidateBookingServiceRequest(
            roomId: new RoomId($bookingItem->roomId()),
            checkInCheckOutDateRange: $checkInCheckOutDateRange,
        );
        $this->validateBookingService
            ->expects(self::once())
            ->method('execute')
            ->with($validateServiceRequest)
            ->willThrowException(new RoomIsAlreadyBookedInTheseDaysException($roomIdVO, $checkInDate, $checkOutDate));

        $message = "Room with id {$roomId} is already booked between {$checkInDate->value()->format('Y-m-d')} and {$checkOutDate->value()->format('Y-m-d')}";
        $expected = new CreateBookingListUseCaseResponse(
            success: false,
            errorList: [new BookingValidationError($message)]
        );

        $this->transactionManager
            ->expects(self::never())
            ->method('execute');

        $this->findRoomService
            ->expects(self::never())
            ->method('execute');

        $this->createBookingService
            ->expects(self::never())
            ->method('execute');

        $actual = $this->sut->execute($request);

        self::assertEquals($expected, $actual);
    }

    public function test_when_room_does_not_exist_then_returns_validation_errors(): void
    {
        $userId = UuidMother::random();
        $roomId = UuidMother::random();
        $roomIdVO = new RoomId($roomId);
        $checkInDate = new CheckInDate(DateMother::randomFromToday());
        $carbonCheckOutDate = $checkInDate->value()->clone()->addDays(IntegerMother::between(2, 30));
        $checkOutDate = new CheckOutDate($carbonCheckOutDate);
        $checkInCheckOutDateRange = new CheckInCheckOutDateRange($checkInDate, $checkOutDate);

        $bookingItem = new BookingItem(
            userId: $userId,
            roomId: $roomId,
            checkInDate: $checkInDate->value()->toDateString(),
            checkOutDate: $checkOutDate->value()->toDateString(),
        );

        $request = new CreateBookingListUseCaseRequest([$bookingItem]);

        $validateServiceRequest = new ValidateBookingServiceRequest(
            roomId: $roomIdVO,
            checkInCheckOutDateRange: $checkInCheckOutDateRange,
        );
        $this->validateBookingService
            ->expects(self::once())
            ->method('execute')
            ->with($validateServiceRequest);

        $this->transactionManager
            ->expects(self::once())
            ->method('execute')
            ->willReturnCallback(function (callable $callback) {
                return $callback();
            });

        $this->findRoomService
            ->expects(self::once())
            ->method('execute')
            ->with(new FindRoomServiceRequest($roomIdVO))
            ->willThrowException(new RoomNotFoundException($roomIdVO));

        $this->expectException(RoomNotFoundException::class);

        $this->createBookingService
            ->expects(self::never())
            ->method('execute');

        $this->sut->execute($request);
    }
}
