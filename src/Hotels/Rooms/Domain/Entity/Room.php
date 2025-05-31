<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomLabel;

/**
 * Room Entity.
 * 
 * This class represents a room in a hotel. It extends the Eloquent Model
 * and provides value object wrappers for its attributes.
 * 
 * The room is identified by a unique UUID and belongs to a hotel.
 * Each room has a unique label within its hotel.
 */
class Room extends Model
{
    protected $table = 'rooms';

    protected $primaryKey = 'room_id';

    protected $keyType = 'string';
    public $incrementing = false;

    // Region setters and getters
    /**
     * Gets the room's unique identifier.
     * 
     * @return RoomId The room's UUID wrapped in a value object
     */
    public function id(): RoomId
    {
        return new RoomId($this->getAttributeValue('room_id'));
    }

    /**
     * Sets the room's unique identifier.
     * 
     * @param RoomId $id The room's UUID wrapped in a value object
     * @return self For method chaining
     */
    public function setId(RoomId $id): self
    {
        return $this->setAttribute('room_id', $id->value());
    }

    /**
     * Gets the ID of the hotel this room belongs to.
     * 
     * @return HotelId The hotel's UUID wrapped in a value object
     */
    public function hotelId(): HotelId
    {
        return new HotelId($this->getAttributeValue('hotel_id'));
    }

    /**
     * Sets the ID of the hotel this room belongs to.
     * 
     * @param HotelId $label The hotel's UUID wrapped in a value object
     * @return self For method chaining
     */
    public function setHotelId(HotelId $label): self
    {
        return $this->setAttribute('hotel_id', $label->value());
    }

    /**
     * Gets the room's label within its hotel.
     * 
     * @return RoomLabel The room's label wrapped in a value object
     */
    public function roomLabel(): RoomLabel
    {
        return new RoomLabel($this->getAttributeValue('room_label'));
    }

    /**
     * Sets the room's label within its hotel.
     * 
     * @param RoomLabel $label The room's label wrapped in a value object
     * @return self For method chaining
     */
    public function setRoomLabel(RoomLabel $label): self
    {
        return $this->setAttribute('room_label', $label->value());
    }
    // End region setters and getters


    // Region relations
    /**
     * Gets the relationship to the hotel this room belongs to.
     * 
     * @return BelongsTo The Eloquent relationship to the Hotel model
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }
}
