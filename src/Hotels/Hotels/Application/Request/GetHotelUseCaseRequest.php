<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\Request;

/**
 * Get Hotel Use Case Request.
 * 
 * This class represents the request data for retrieving a hotel.
 * It encapsulates the hotel identifier required for the operation.
 */
class GetHotelUseCaseRequest
{
    /**
     * Creates a new GetHotelUseCaseRequest instance.
     * 
     * @param string $hotelId The unique identifier of the hotel to retrieve
     */
    public function __construct(
        private string $hotelId,
    ) {
    }

    /**
     * Gets the hotel identifier.
     * 
     * @return string The hotel identifier
     */
    public function hotelId(): string
    {
        return $this->hotelId;
    }
}
