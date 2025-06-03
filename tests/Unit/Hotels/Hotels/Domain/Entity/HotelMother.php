<?php

declare(strict_types=1);

namespace Tests\Unit\Hotels\Hotels\Domain\Entity;

use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCity;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCountry;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelName;
use Tests\Unit\Shared\Common\Domain\ValueObject\CityMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\CountryMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\WordMother;

/**
 * Class for creating Hotel test instances.
 *
 * This class provides methods to create Hotel entities with random or specific values
 * for testing purposes. It ensures consistent test data generation across the test suite.
 */
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
            ->setCity($hotelCity ?? new HotelCity(CityMother::random()))
            ->setCountry($country ?? new HotelCountry(CountryMother::random()));
    }
}
