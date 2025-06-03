<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Response;

use Src\Hotels\Hotels\Domain\Entity\Hotel;

/**
 * Find Hotel Service Response.
 *
 * This class represents the response data from a hotel find operation.
 * It encapsulates the found hotel entity.
 */
class FindHotelServiceResponse
{
    /**
     * Creates a new FindHotelServiceResponse instance.
     *
     * @param Hotel $hotel The found hotel entity
     */
    public function __construct(
        private Hotel $hotel
    ) {
    }

    /**
     * Gets the found hotel.
     *
     * @return Hotel The hotel entity
     */
    public function hotel(): Hotel
    {
        return $this->hotel;
    }
}
