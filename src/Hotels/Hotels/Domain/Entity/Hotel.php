<?php

declare(strict_types=1);

namespace Src\Hotels\Hotels\Domain\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Bookings\Domain\Entity\Booking;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCity;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCountry;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelName;
use Src\Hotels\Rooms\Domain\Entity\Room;

class Hotel extends Model
{
    protected $table = 'hotels';

    protected $primaryKey = 'hotel_id';
    protected $keyType = 'string';
    public $incrementing = false;

    // Region setters and getters
    public function id(): HotelId
    {
        return new HotelId($this->getAttributeValue('hotel_id'));
    }

    public function setId(HotelId $id): self
    {
        return $this->setAttribute('hotel_id', $id->value());
    }

    public function name(): HotelName
    {
        return new HotelName($this->getAttributeValue('name'));
    }

    public function setName(HotelName $name): self
    {
        return $this->setAttribute('name', $name->value());
    }

    public function city(): HotelCity
    {
        return new HotelCity($this->getAttributeValue('city'));
    }

    public function setCity(HotelCity $city): self
    {
        return $this->setAttribute('city', $city->value());
    }

    public function country(): HotelCountry
    {
        return new HotelCountry($this->getAttributeValue('country'));
    }

    public function setCountry(HotelCountry $country): self
    {
        return $this->setAttribute('country', $country->value());
    }

    // End region setters and getters

    // ---------------------------------------------------------------------------------------------------------

    // Region relations

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'hotel_id', 'hotel_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'hotel_id', 'hotel_id');
    }

    // End region relations

    // ---------------------------------------------------------------------------------------------------------

    // Start region methods

    public function numberOfRooms(): int
    {
        return $this->getRelationValue('rooms')->count();
    }

    // End region methods
}
