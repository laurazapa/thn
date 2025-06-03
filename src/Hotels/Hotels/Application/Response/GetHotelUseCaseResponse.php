<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\Response;

use JsonSerializable;

/**
 * Get Hotel Use Case Response.
 *
 * This class represents the response data for a hotel retrieval operation.
 * It implements JsonSerializable to allow easy conversion to JSON format.
 */
class GetHotelUseCaseResponse implements JsonSerializable
{
    /**
     * Creates a new GetHotelUseCaseResponse instance.
     *
     * @param string $id The unique identifier of the hotel
     * @param string $name The name of the hotel
     * @param string $city The city where the hotel is located
     * @param string $country The country where the hotel is located
     * @param int $numberOfRooms The total number of rooms in the hotel
     */
    public function __construct(
        private string $id,
        private string $name,
        private string $city,
        private string $country,
        private int $numberOfRooms,
    ) {}

    /**
     * Gets the hotel identifier.
     *
     * @return string The hotel identifier
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * Gets the hotel name.
     *
     * @return string The hotel name
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Gets the hotel city.
     *
     * @return string The city where the hotel is located
     */
    public function city(): string
    {
        return $this->city;
    }

    /**
     * Gets the hotel country.
     *
     * @return string The country where the hotel is located
     */
    public function country(): string
    {
        return $this->country;
    }

    /**
     * Gets the number of rooms in the hotel.
     *
     * @return int The total number of rooms
     */
    public function numberOfRooms(): int
    {
        return $this->numberOfRooms;
    }

    /**
     * Converts the response to a JSON-serializable array.
     *
     * @return array<string, mixed> The response data as an array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'country' => $this->country,
            'numberOfRooms' => $this->numberOfRooms,
        ];
    }
}
