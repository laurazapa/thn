<?php

namespace Apps\Bookings\Mapper;

use Apps\Bookings\Request\CreateBookingListControllerRequest;
use Src\Bookings\Application\Request\BookingItem;
use Src\Bookings\Application\Request\CreateBookingListUseCaseRequest;

class CreateBookingListRequestMapper
{
    public function fromRequest(CreateBookingListControllerRequest $request): CreateBookingListUseCaseRequest
    {
        $bookingItems = collect($request->input('bookings'))
            ->map(fn (array $item) => new BookingItem(
                userId: $item['userId'],
                roomId: $item['roomId'],
                checkInDate: $item['checkInDate'],
                checkOutDate: $item['checkOutDate'],
            ))
            ->toArray();

        return new CreateBookingListUseCaseRequest($bookingItems);
    }
}
