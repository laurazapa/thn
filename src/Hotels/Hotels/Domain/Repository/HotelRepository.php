<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Repository;

use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;

interface HotelRepository
{
    public function find(HotelId $hotelId, array $relations = []): ?Hotel;

    /**
     * @return HotelUserCount[]
     */
    public function getUniqueUsersPerHotel(): array;
}
