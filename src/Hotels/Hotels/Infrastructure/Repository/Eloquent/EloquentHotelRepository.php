<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Infrastructure\Repository\Eloquent;

use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\Repository\HotelRepository;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;

class EloquentHotelRepository implements HotelRepository
{
    public function find(HotelId $hotelId, array $relations = []): ?Hotel
    {
        return Hotel::query()
            ->with($relations)
            ->find($hotelId->value());
    }

    /**
     * @return HotelUserCount[]
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
