<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Application\Response;

use JsonSerializable;
use Src\Hotels\Hotels\Domain\ValueObject\HotelUserCount;

class GetHotelUserCountListUseCaseResponse implements JsonSerializable
{
    /**
     * @param HotelUserCount[] $data
     */
    public function __construct(
        private array $data
    ) {
    }

    /**
     * @return HotelUserCount[]
     */
    public function data(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        return ['data' => $this->data];
    }
}
