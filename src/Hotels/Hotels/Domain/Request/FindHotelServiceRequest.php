<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Request;

use Src\Hotels\Hotels\Domain\ValueObject\HotelId;

class FindHotelServiceRequest
{
    public function __construct(
        private HotelId $hotelId,
        private array $relations = [],
    ) {
    }

    public function hotelId(): HotelId
    {
        return $this->hotelId;
    }

    /**
     * @return string[] array
     */
    public function relations(): array
    {
        return $this->relations;
    }
}
