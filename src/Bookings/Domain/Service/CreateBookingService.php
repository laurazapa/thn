<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Service;

use Src\Bookings\Domain\Entity\Booking;
use Src\Bookings\Domain\Repository\BookingRepository;
use Src\Bookings\Domain\Request\CreateBookingServiceRequest;
use Src\Bookings\Domain\Response\CreateBookingServiceResponse;
use Src\Bookings\Domain\ValueObject\BookingId;
use Src\Shared\Common\Domain\Service\UuidGenerator\UuidGenerator;

/**
 * Service responsible for creating new bookings.
 * This service handles the creation of booking entities and their persistence.
 */
class CreateBookingService
{
    public function __construct(
        private BookingRepository $bookingRepository,
        private UuidGenerator $uuidGenerator,
    ) {
    }

    /**
     * Creates a new booking with the provided data.
     * 
     * The process:
     * 1. Generates a new UUID for the booking
     * 2. Creates a new Booking entity with all required data
     * 3. Persists the booking through the repository
     * 
     * @param CreateBookingServiceRequest $request The booking data
     * @return CreateBookingServiceResponse Response containing the created booking
     */
    public function execute(CreateBookingServiceRequest $request): CreateBookingServiceResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $booking = new Booking()
            ->setId(new BookingId($uuid))
            ->setUserId($request->userId())
            ->setRoomId($request->roomId())
            ->setHotelId($request->hotelId())
            ->setCheckInDate($request->checkInDate())
            ->setCheckOutDate($request->checkOutDate());

        $booking = $this->bookingRepository->create($booking);

        return new CreateBookingServiceResponse($booking);
    }
}
