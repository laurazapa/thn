<?php

namespace Apps\Bookings\Mapper;

use Apps\Bookings\Request\CreateBookingControllerRequest;
use Src\Bookings\Application\Request\BookingItem;
use Src\Bookings\Application\Request\CreateBookingUseCaseRequest;

class CreateBookingRequestMapper
{
    public function fromRequest(CreateBookingControllerRequest $request): CreateBookingUseCaseRequest
    {
        $bookingItems = collect($request->input('bookings'))
            ->map(fn (array $item) => new BookingItem(
                userId: $item['userId'],
                roomId: $item['roomId'],
                checkInDate: $item['checkInDate'],
                checkOutDate: $item['checkOutDate'],
            ))
            ->toArray();

        return new CreateBookingUseCaseRequest($bookingItems);
    }
}
