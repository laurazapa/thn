<?php

declare(strict_types=1);

namespace Src\Hotels\Rooms\Domain\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomLabel;

class Room extends Model
{
    protected $table = 'rooms';

    protected $primaryKey = 'room_id';

    protected $keyType = 'string';
    public $incrementing = false;

    // Region setters and getters
    public function id(): RoomId
    {
        return new RoomId($this->getAttributeValue('room_id'));
    }

    public function setId(RoomId $id): self
    {
        return $this->setAttribute('room_id', $id->value());
    }

    public function hotelId(): HotelId
    {
        return new HotelId($this->getAttributeValue('hotel_id'));
    }

    public function setHotelId(HotelId $label): self
    {
        return $this->setAttribute('hotel_id', $label->value());
    }

    public function roomLabel(): RoomLabel
    {
        return new RoomLabel($this->getAttributeValue('room_label'));
    }

    public function setRoomLabel(RoomLabel $label): self
    {
        return $this->setAttribute('room_label', $label->value());
    }
    // End region setters and getters


    // Region relations
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }
}
