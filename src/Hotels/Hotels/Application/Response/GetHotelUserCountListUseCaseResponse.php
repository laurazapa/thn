<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\Response;

use JsonSerializable;
use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;

/**
 * Get Hotel User Count List Use Case Response.
 * 
 * This class represents the response data for retrieving a list of hotel user counts.
 * It implements JsonSerializable to allow easy conversion to JSON format.
 */
class GetHotelUserCountListUseCaseResponse implements JsonSerializable
{
    /**
     * Creates a new GetHotelUserCountListUseCaseResponse instance.
     * 
     * @param HotelUserCount[] $data Array of hotel user count data
     */
    public function __construct(
        private array $data
    ) {
    }

    /**
     * Gets the list of hotel user counts.
     * 
     * @return HotelUserCount[] Array of hotel user count data
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Converts the response to a JSON-serializable array.
     * 
     * @return array<string, HotelUserCount[]> The response data as an array
     */
    public function jsonSerialize(): array
    {
        return ['data' => $this->data];
    }
}
