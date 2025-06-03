<?php

declare(strict_types=1);

namespace Apps\Bookings\Mapper;

use Apps\Bookings\Request\CreateBookingListControllerRequest;
use Src\Bookings\Application\Request\BookingItem;
use Src\Bookings\Application\Request\CreateBookingListUseCaseRequest;

/**
 * Mapper for transforming booking list creation requests.
 *
 * This class is responsible for mapping between the controller request format
 * and the use case request format. It transforms the raw HTTP request data
 * into a structured format that the use case can understand.
 *
 * The mapping process:
 * 1. Takes the raw bookings array from the controller request
 * 2. Transforms each booking item into a BookingItem DTO
 * 3. Creates a new CreateBookingListUseCaseRequest with the transformed items
 */
class CreateBookingListRequestMapper
{
    /**
     * Transforms a controller request into a use case request.
     *
     * This method maps the raw HTTP request data into a format suitable
     * for the use case layer, ensuring proper data structure and type safety.
     *
     * @param CreateBookingListControllerRequest $request The raw HTTP request containing booking data
     * @return CreateBookingListUseCaseRequest The transformed request ready for use case processing
     */
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
