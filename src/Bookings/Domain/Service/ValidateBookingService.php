<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Service;

use Carbon\Carbon;
use Src\Bookings\Domain\Exception\BookingDatesAreInThePastException;
use Src\Bookings\Domain\Exception\RoomIsAlreadyBookedInTheseDaysException;
use Src\Bookings\Domain\Repository\BookingRepository;
use Src\Bookings\Domain\Request\ValidateBookingServiceRequest;

class ValidateBookingService
{
    public function __construct(
        private BookingRepository $bookingRepository,
    ) {
    }

    /**
     * @throws BookingDatesAreInThePastException
     * @throws RoomIsAlreadyBookedInTheseDaysException
     */
    public function execute(ValidateBookingServiceRequest $request): void
    {
        $this->validateDatesAreNotInThePast($request);

        $this->validateRoomIsNotBookedInTheseDates($request);
    }

    /**
     * @throws BookingDatesAreInThePastException
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
     * @throws RoomIsAlreadyBookedInTheseDaysException
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
