<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Exception;

use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Shared\Common\Domain\Exception\DataNotFoundException;

/**
 * Hotel Not Found Exception.
 * 
 * This exception is thrown when attempting to access a hotel that does not exist
 * in the system. It extends DataNotFoundException to provide specific error
 * information about the missing hotel.
 */
class HotelNotFoundException extends DataNotFoundException
{
    /**
     * Creates a new HotelNotFoundException instance.
     * 
     * @param HotelId $hotelId The identifier of the hotel that was not found
     */
    public function __construct(HotelId $hotelId)
    {
        parent::__construct("Hotel with id {$hotelId->value()} not found");
    }
}
