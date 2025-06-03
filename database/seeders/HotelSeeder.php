<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCity;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCountry;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelName;
use Tests\Unit\Shared\Common\Domain\ValueObject\CityMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\CountryMother;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        // Hardcoded IDs for documentation purposes
        $hotels = [
            [
                'id' => '9d491317-a39b-4ffd-91fe-9a91a5d21ece',
                'name' => 'Pramana Watu Kurung',
            ],
            [
                'id' => '5a69179a-3b9d-4c0e-960d-91649eaab013',
                'name' => 'El racó de Madremanya',
            ],
        ];

        foreach ($hotels as $hotelData) {
            $hotel = new Hotel();
            $hotel->setId(new HotelId($hotelData['id']));
            $hotel->setName(new HotelName($hotelData['name']));
            $hotel->setCity(new HotelCity(CityMother::random()));
            $hotel->setCountry(new HotelCountry(CountryMother::random()));
            $hotel->save();
        }
    }
}
