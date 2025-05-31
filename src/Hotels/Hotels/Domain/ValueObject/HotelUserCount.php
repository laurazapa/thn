<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\ValueObject;

use JsonSerializable;

class HotelUserCount implements JsonSerializable
{
    public function __construct(
        private string $id,
        private int $users
    ) {
    }

    public function id(): string {
        return $this->id;
    }

    public function users(): int {
        return $this->users;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'users' => $this->users,
        ];
    }
}
