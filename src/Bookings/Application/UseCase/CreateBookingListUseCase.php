<?php

declare(strict_types=1);

namespace Src\Bookings\Application\UseCase;

use Carbon\Carbon;
use DomainException;
use Src\Bookings\Application\Request\BookingItem;
use Src\Bookings\Application\Request\CreateBookingListUseCaseRequest;
use Src\Bookings\Application\Response\BookingValidationError;
use Src\Bookings\Application\Response\BookingValidationResult;
use Src\Bookings\Application\Response\CreateBookingListUseCaseResponse;
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

/**
 * Use case responsible for creating multiple bookings in a single transaction.
 * This use case orchestrates the validation and creation of bookings, ensuring
 * all operations are atomic and consistent.
 */
class CreateBookingListUseCase
{
    public function __construct(
        private ValidateBookingService $validateBookingService,
        private CreateBookingService $createBookingService,
        private FindRoomService $findRoomService,
        private TransactionManager $transactionManager,
    ) {
    }

    /**
     * Executes the booking list creation process.
     *
     * The process follows these steps:
     * 1. Validates all bookings in the list
     * 2. If any validation fails, returns all errors
     * 3. If all validations pass, creates all bookings in a single transaction
     *
     * @param CreateBookingListUseCaseRequest $request The request containing the list of bookings to create
     * @return CreateBookingListUseCaseResponse Response containing success status and either booking IDs or errors
     */
    public function execute(CreateBookingListUseCaseRequest $request): CreateBookingListUseCaseResponse
    {
        $validationResults = $this->validateAllBookings($request->bookingList());

        if ($validationResults->hasErrors()) {
            return new CreateBookingListUseCaseResponse(
                success: false,
                errorList: $validationResults->getErrors()
            );
        }

        $createdBookings = $this->createAllBookingsInTransaction($request->bookingList());

        return new CreateBookingListUseCaseResponse(
            success: true,
            bookingIdList: $createdBookings
        );
    }

    /**
     * Validates all bookings in the list.
     *
     * @param BookingItem[] $bookingList List of bookings to validate
     * @return BookingValidationResult Contains any validation errors found
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
     * Creates all bookings within a transaction to ensure atomicity.
     *
     * @param BookingItem[] $bookingList List of bookings to create
     * @return string[] List of created booking IDs
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

    /**
     * Validates a single booking by checking:
     * - Dates are not in the past
     * - Room is available for the selected dates
     *
     * @param BookingItem $bookingItem The booking to validate
     */
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

    /**
     * Creates a single booking by:
     * 1. Finding the associated hotel for the room
     * 2. Creating the booking with all required data
     *
     * @param BookingItem $bookingItem The booking data
     * @return Booking The created booking entity
     */
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
