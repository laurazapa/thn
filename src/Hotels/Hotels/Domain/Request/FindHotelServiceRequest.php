<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Request;

use Src\Hotels\Hotels\Domain\ValueObject\HotelId;

/**
 * Find Hotel Service Request.
 * 
 * This class represents the request data for finding a hotel.
 * It encapsulates the hotel identifier and any relations to be loaded.
 */
class FindHotelServiceRequest
{
    /**
     * Creates a new FindHotelServiceRequest instance.
     * 
     * @param HotelId $hotelId The identifier of the hotel to find
     * @param array $relations The relations to eager load with the hotel
     */
    public function __construct(
        private HotelId $hotelId,
        private array $relations = [],
    ) {
    }

    /**
     * Gets the hotel identifier.
     * 
     * @return HotelId The hotel identifier
     */
    public function hotelId(): HotelId
    {
        return $this->hotelId;
    }

    /**
     * Gets the relations to be loaded with the hotel.
     * 
     * @return string[] Array of relation names to eager load
     */
    public function relations(): array
    {
        return $this->relations;
    }
}
