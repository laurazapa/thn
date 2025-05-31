<?php

declare(strict_types=1);

namespace Src\Bookings\Application\UseCase;

use Carbon\Carbon;
use DomainException;
use Src\Bookings\Application\Request\BookingItem;
use Src\Bookings\Application\Request\CreateBookingUseCaseRequest;
use Src\Bookings\Application\Response\BookingValidationError;
use Src\Bookings\Application\Response\BookingValidationResult;
use Src\Bookings\Application\Response\CreateBookingUseCaseResponse;
use Src\Bookings\Domain\Entity\Booking;
use Src\Bookings\Domain\Request\CreateBookingServiceRequest;
use Src\Bookings\Domain\Request\ValidateBookingServiceRequest;
use Src\Bookings\Domain\Service\CreateBookingService;
use Src\Bookings\Domain\Service\ValidateBookingService;
use Src\Bookings\Domain\ValueObject\CheckInCheckOutDateRange;
use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Hotels\Rooms\Domain\Request\FindRoomServiceRequest;
use Src\Hotels\Rooms\Domain\Service\FindRoomService;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Shared\Common\Domain\Transaction\TransactionManager;
use Src\Users\Domain\ValueObject\UserId;

class CreateBookingUseCase
{
    public function __construct(
        private ValidateBookingService $validateBookingService,
        private CreateBookingService $createBookingService,
        private FindRoomService $findRoomService,
        private TransactionManager $transactionManager,
    ) {
    }

    public function execute(CreateBookingUseCaseRequest $request): CreateBookingUseCaseResponse
    {
        // 1. Validar todos los bookings primero
        $validationResults = $this->validateAllBookings($request->bookingList());

        // 2. Si hay errores, devolverlos todos
        if ($validationResults->hasErrors()) {
            return new CreateBookingUseCaseResponse(
                success: false,
                errorList: $validationResults->getErrors()
            );
        }

        // 3. Crear todos los bookings en una transacción
        $createdBookings = $this->createAllBookingsInTransaction($request->bookingList());

        return new CreateBookingUseCaseResponse(
            success: true,
            bookingIdList: $createdBookings
        );
    }

    /**
     * @param BookingItem[] $bookingList
     */
    private function validateAllBookings(array $bookingList): BookingValidationResult
    {
        $errors = [];
        foreach ($bookingList as $booking) {
            try {
                $this->validateBooking($booking);
            } catch (DomainException $e) {
                $errors[] = new BookingValidationError($e->getMessage());
            }
        }
        return new BookingValidationResult($errors);
    }

    /**
     * @param BookingItem[] $bookingList
     * @return string[]
     */
    private function createAllBookingsInTransaction(array $bookingList): array
    {
        return $this->transactionManager->execute(function () use ($bookingList) {
            $createdBookings = [];
            foreach ($bookingList as $booking) {
                $createdBooking = $this->createBooking($booking);
                $createdBookings[] = $createdBooking->id()->value();
            }
            return $createdBookings;
        });
    }

    private function validateBooking(BookingItem $bookingItem): void
    {
        $checkInDate = new CheckInDate(Carbon::parse($bookingItem->checkInDate()));
        $checkOutDate = new CheckOutDate(Carbon::parse($bookingItem->checkOutDate()));
        $checkInCheckOutDateRange = new CheckInCheckOutDateRange($checkInDate, $checkOutDate);

        $serviceRequest = new ValidateBookingServiceRequest(
            roomId: new RoomId($bookingItem->roomId()),
            checkInCheckOutDateRange: $checkInCheckOutDateRange,
        );

        $this->validateBookingService->execute($serviceRequest);
    }

    private function createBooking(BookingItem $bookingItem): Booking
    {
        $roomId = new RoomId($bookingItem->roomId());
        $hotelId = $this->findRoomService->execute(
            new FindRoomServiceRequest($roomId)
        )->room()->hotelId();

        $serviceRequest = new CreateBookingServiceRequest(
            userId: new UserId($bookingItem->userId()),
            roomId: $roomId,
            hotelId: $hotelId,
            checkInDate: new CheckInDate(Carbon::parse($bookingItem->checkInDate())),
            checkOutDate: new CheckOutDate(Carbon::parse($bookingItem->checkOutDate())),
        );

        return $this->createBookingService->execute($serviceRequest)->booking();
    }
}
