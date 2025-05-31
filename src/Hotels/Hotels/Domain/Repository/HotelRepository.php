<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Repository;

use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;

/**
 * Hotel Repository Interface.
 *
 * This interface defines the contract for hotel data access operations.
 * It provides methods for finding hotels and retrieving user statistics.
 * Note: While it attempts to follow the Repository pattern, the implementation
 * is not fully decoupled from the ORM as the Hotel entity extends Eloquent's Model.
 */
interface HotelRepository
{
    /**
     * Finds a hotel by its identifier.
     *
     * @param HotelId $hotelId The identifier of the hotel to find
     * @param array $relations The relations to eager load with the hotel
     * @return Hotel|null The found hotel or null if not found
     */
    public function find(HotelId $hotelId, array $relations = []): ?Hotel;

    /**
     * Gets the count of unique users per hotel.
     *
     * @return HotelUserCount[] Array of hotel user count data
     */
    public function getUniqueUsersPerHotel(): array;
}
