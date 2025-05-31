<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Service;

use Carbon\Carbon;
use Src\Bookings\Domain\Exception\BookingDatesAreInThePastException;
use Src\Bookings\Domain\Exception\RoomIsAlreadyBookedInTheseDaysException;
use Src\Bookings\Domain\Repository\BookingRepository;
use Src\Bookings\Domain\Request\ValidateBookingServiceRequest;

/**
 * Service responsible for validating booking requests.
 * This service ensures that bookings meet all business rules before creation.
 */
class ValidateBookingService
{
    public function __construct(
        private BookingRepository $bookingRepository,
    ) {
    }

    /**
     * Executes the booking validation process.
     * Validates that:
     * 1. Booking dates are not in the past
     * 2. Room is available for the selected dates
     * 
     * @param ValidateBookingServiceRequest $request The booking request to validate
     * @throws BookingDatesAreInThePastException If check-in date is in the past
     * @throws RoomIsAlreadyBookedInTheseDaysException If room is already booked for the selected dates
     */
    public function execute(ValidateBookingServiceRequest $request): void
    {
        $this->validateDatesAreNotInThePast($request);

        $this->validateRoomIsNotBookedInTheseDates($request);
    }

    /**
     * Validates that the booking dates are not in the past.
     * 
     * @param ValidateBookingServiceRequest $request The booking request to validate
     * @throws BookingDatesAreInThePastException If check-in date is before today
     */
    private function validateDatesAreNotInThePast(ValidateBookingServiceRequest $request): void
    {
        $roomId = $request->roomId();
        $checkInDate = $request->checkInCheckOutDateRange()->startDate();
        $currentDate = Carbon::today();

        if ($checkInDate->value() < $currentDate) {
            throw new BookingDatesAreInThePastException($roomId, $checkInDate);
        }
    }

    /**
     * Validates that the room is available for the selected dates.
     * Checks if there are any existing bookings that overlap with the requested dates.
     * 
     * @param ValidateBookingServiceRequest $request The booking request to validate
     * @throws RoomIsAlreadyBookedInTheseDaysException If room is already booked for the selected dates
     */
    private function validateRoomIsNotBookedInTheseDates(ValidateBookingServiceRequest $request): void
    {
        $checkInDate = $request->checkInCheckOutDateRange()->startDate();
        $checkOutDate = $request->checkInCheckOutDateRange()->endDate();
        $roomId = $request->roomId();

        $bookingExists = $this->bookingRepository->findIfBookingExistsForGivenRoomAndDates($roomId, $checkInDate, $checkOutDate);

        if ($bookingExists) {
            throw new RoomIsAlreadyBookedInTheseDaysException($roomId, $checkInDate, $checkOutDate);
        }
    }
}
