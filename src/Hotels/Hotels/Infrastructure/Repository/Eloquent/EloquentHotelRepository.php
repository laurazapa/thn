<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Infrastructure\Repository\Eloquent;

use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\Repository\HotelRepository;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;

/**
 * Eloquent Hotel Repository Implementation.
 *
 * This class implements the HotelRepository interface using Laravel's Eloquent ORM.
 * It provides concrete implementations for retrieval of a hotel and
 * hotel user statistics.
 */
class EloquentHotelRepository implements HotelRepository
{
    /**
     * Finds a hotel by its ID using Eloquent ORM.
     *
     * @param HotelId $hotelId The unique identifier of the hotel to find
     * @param array $relations Optional array of relations to eager load
     * @return Hotel|null The found hotel or null if not found
     */
    public function find(HotelId $hotelId, array $relations = []): ?Hotel
    {
        return Hotel::query()
            ->with($relations)
            ->find($hotelId->value());
    }

    /**
     * Gets the count of unique users per hotel.
     *
     * This method performs a database query that:
     * 1. Joins the hotels and bookings tables
     * 2. Groups by hotel ID
     * 3. Counts distinct user IDs per hotel
     *
     * @return HotelUserCount[] Array of hotel user count data
     */
    public function getUniqueUsersPerHotel(): array
    {
        return Hotel::query()
            ->select('hotels.hotel_id')
            ->selectRaw('COUNT(DISTINCT bookings.user_id) as unique_users')
            ->leftjoin('bookings', 'hotels.hotel_id', '=', 'bookings.hotel_id')
            ->groupBy('hotels.hotel_id')
            ->get()
            ->map(fn ($result) => new HotelUserCount(
                id: $result->getAttributeValue('hotel_id'),
                users: (int) $result->getAttributeValue('unique_users'),
            ))
            ->all();
    }
}
