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

/**
 * Hotel Entity.
 *
 * This class represents a hotel in the domain. The entity encapsulates hotel data
 * and behavior, using value objects for type safety and domain validation.
 */
class Hotel extends Model
{
    protected $table = 'hotels';

    protected $primaryKey = 'hotel_id';
    protected $keyType = 'string';
    public $incrementing = false;

    // Region setters and getters

    /**
     * Gets the hotel identifier.
     *
     * @return HotelId The hotel identifier value object
     */
    public function id(): HotelId
    {
        return new HotelId($this->getAttributeValue('hotel_id'));
    }

    /**
     * Sets the hotel identifier.
     *
     * @param HotelId $id The hotel identifier value object
     * @return self For method chaining
     */
    public function setId(HotelId $id): self
    {
        return $this->setAttribute('hotel_id', $id->value());
    }

    /**
     * Gets the hotel name.
     *
     * @return HotelName The hotel name value object
     */
    public function name(): HotelName
    {
        return new HotelName($this->getAttributeValue('name'));
    }

    /**
     * Sets the hotel name.
     *
     * @param HotelName $name The hotel name value object
     * @return self For method chaining
     */
    public function setName(HotelName $name): self
    {
        return $this->setAttribute('name', $name->value());
    }

    /**
     * Gets the hotel city.
     *
     * @return HotelCity The hotel city value object
     */
    public function city(): HotelCity
    {
        return new HotelCity($this->getAttributeValue('city'));
    }

    /**
     * Sets the hotel city.
     *
     * @param HotelCity $city The hotel city value object
     * @return self For method chaining
     */
    public function setCity(HotelCity $city): self
    {
        return $this->setAttribute('city', $city->value());
    }

    /**
     * Gets the hotel country.
     *
     * @return HotelCountry The hotel country value object
     */
    public function country(): HotelCountry
    {
        return new HotelCountry($this->getAttributeValue('country'));
    }

    /**
     * Sets the hotel country.
     *
     * @param HotelCountry $country The hotel country value object
     * @return self For method chaining
     */
    public function setCountry(HotelCountry $country): self
    {
        return $this->setAttribute('country', $country->value());
    }

    // End region setters and getters

    // ---------------------------------------------------------------------------------------------------------

    // Region relations

    /**
     * Gets the rooms associated with this hotel.
     *
     * @return HasMany The relationship to the hotel's rooms
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'hotel_id', 'hotel_id');
    }

    /**
     * Gets the bookings associated with this hotel.
     *
     * @return HasMany The relationship to the hotel's bookings
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'hotel_id', 'hotel_id');
    }

    // End region relations

    // ---------------------------------------------------------------------------------------------------------

    // Start region methods

    /**
     * Gets the total number of rooms in the hotel.
     *
     * @return int The count of rooms associated with this hotel
     */
    public function numberOfRooms(): int
    {
        return $this->getRelationValue('rooms')->count();
    }

    // End region methods
}
