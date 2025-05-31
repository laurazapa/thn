<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Service;

use Src\Bookings\Domain\Entity\Booking;
use Src\Bookings\Domain\Repository\BookingRepository;
use Src\Bookings\Domain\Request\CreateBookingServiceRequest;
use Src\Bookings\Domain\Response\CreateBookingServiceResponse;
use Src\Bookings\Domain\ValueObject\BookingId;
use Src\Shared\Common\Domain\Service\UuidGenerator\UuidGenerator;

class CreateBookingService
{
    public function __construct(
        private BookingRepository $bookingRepository,
        private UuidGenerator $uuidGenerator,
    ) {
    }

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
