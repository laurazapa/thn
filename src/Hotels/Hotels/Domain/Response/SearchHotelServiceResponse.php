<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Response;

use Src\Hotels\Hotels\Domain\Entity\Hotel;

/**
 * Search Hotel Service Response.
 *
 * This class represents the response data from a hotel search operation.
 * It encapsulates the found hotel entity, which may be null.
 */
class SearchHotelServiceResponse
{
    /**
     * Creates a new SearchHotelServiceResponse instance.
     *
     * @param Hotel|null $hotel The found hotel entity, or null if not found
     */
    public function __construct(
        private ?Hotel $hotel = null
    ) {
    }

    /**
     * Gets the found hotel.
     *
     * @return Hotel|null The hotel entity, or null if not found
     */
    public function hotel(): ?Hotel
    {
        return $this->hotel;
    }
}
