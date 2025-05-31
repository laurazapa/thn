<?php

declare(strict_types=1);

namespace Src\Bookings\Domain\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Bookings\Domain\ValueObject\BookingId;
use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Users\Domain\ValueObject\UserId;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $primaryKey = 'booking_id';

    protected $keyType = 'string';
    public $incrementing = false;

    // Region setters and getters
    public function id(): BookingId
    {
        return new BookingId($this->getAttributeValue('booking_id'));
    }

    public function setId(BookingId $id): self
    {
        return $this->setAttribute('booking_id', $id->value());
    }

    public function userId(): UserId
    {
        return new UserId($this->getAttributeValue('user_id'));
    }

    public function setUserId(UserId $userId): self
    {
        return $this->setAttribute('user_id', $userId->value());
    }

    public function roomId(): RoomId
    {
        return new RoomId($this->getAttributeValue('room_id'));
    }

    public function setRoomId(RoomId $roomId): self
    {
        return $this->setAttribute('room_id', $roomId->value());
    }

    public function hotelId(): HotelId
    {
        return new HotelId($this->getAttributeValue('hotel_id'));
    }

    public function setHotelId(HotelId $hotelId): self
    {
        return $this->setAttribute('hotel_id', $hotelId->value());
    }

    public function checkInDate(): CheckInDate
    {
        return new CheckInDate($this->getAttributeValue('check_in_date'));
    }

    public function setCheckInDate(CheckInDate $checkInDate): self
    {
        return $this->setAttribute('check_in_date', $checkInDate->value());
    }

    public function checkOutDate(): CheckOutDate
    {
        return new CheckOutDate($this->getAttributeValue('check_out_date'));
    }

    public function setCheckOutDate(CheckOutDate $checkOutDate): self
    {
        return $this->setAttribute('check_out_date', $checkOutDate->value());
    }

    // Region relations
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }
}
