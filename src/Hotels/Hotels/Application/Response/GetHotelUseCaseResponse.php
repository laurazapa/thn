<?php

namespace Src\Hotels\Hotels\Application\Response;

use JsonSerializable;

class GetHotelUseCaseResponse implements JsonSerializable
{
    public function __construct(
        private string $id,
        private string $name,
        private string $city,
        private string $country,
        private int $numberOfRooms,
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function numberOfRooms(): int
    {
        return $this->numberOfRooms;
    }

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
