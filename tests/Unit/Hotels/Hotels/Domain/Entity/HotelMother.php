<?php

namespace Tests\Unit\Hotels\Hotels\Domain\Entity;

use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCity;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCountry;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelName;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\WordMother;

class HotelMother
{
    public static function create(
        ?HotelId $hotelId = null,
        ?HotelName $hotelName = null,
        ?HotelCity $hotelCity = null,
        ?HotelCountry $country = null,
    ): Hotel {
        return new Hotel()
            ->setId($hotelId ?? new HotelId(UuidMother::random()))
            ->setName($hotelName ?? new HotelName(WordMother::random()))
            ->setCity($hotelCity ?? new HotelCity(WordMother::random()))
            ->setCountry($country ?? new HotelCountry(WordMother::random()));
    }
}
