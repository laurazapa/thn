<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\ValueObject;

use JsonSerializable;

/**
 * Hotel User Count Value Object.
 * 
 * This class represents the count of unique users for a hotel.
 * It implements JsonSerializable to allow easy conversion to JSON format
 * when needed for API responses.
 */
class HotelUserCount implements JsonSerializable
{
    /**
     * Creates a new HotelUserCount instance.
     * 
     * @param string $id The hotel identifier
     * @param int $users The number of unique users for this hotel
     */
    public function __construct(
        private string $id,
        private int $users
    ) {
    }

    /**
     * Gets the hotel identifier.
     * 
     * @return string The hotel identifier
     */
    public function id(): string {
        return $this->id;
    }

    /**
     * Gets the number of unique users.
     * 
     * @return int The count of unique users for this hotel
     */
    public function users(): int {
        return $this->users;
    }

    /**
     * Converts the value object to a JSON-serializable array.
     * 
     * @return array<string, string|int> The value object data as an array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'users' => $this->users,
        ];
    }
}
