<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Exception;

use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Shared\Common\Domain\Exception\DataNotFoundException;

class HotelNotFoundException extends DataNotFoundException
{
    public function __construct(HotelId $hotelId)
    {
        parent::__construct("Hotel with id {$hotelId->value()} not found");
    }
}
