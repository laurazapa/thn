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

/**
 * Entity that represents a booking in the system. The entity encapsulates booking data
 * and behavior, using value objects for type safety and domain validation.
 *
 * This class is currently coupled to Laravel's Model class for practical reasons.
 *
 * While this approach works well for the current needs, a more DDD-compliant
 * approach would be to:
 * 1. Have a pure domain entity without framework dependencies
 * 2. Use a mapper/transformer to convert between domain entity and ORM model
 */
class Booking extends Model
{
    protected $table = 'bookings';

    protected $primaryKey = 'booking_id';

    protected $keyType = 'string';
    public $incrementing = false;

    // Region setters and getters
    /**
     * Gets the booking's unique identifier.
     *
     * @return BookingId The booking's ID
     */
    public function id(): BookingId
    {
        return new BookingId($this->getAttributeValue('booking_id'));
    }

    /**
     * Sets the booking's unique identifier.
     *
     * @param BookingId $id The booking's ID
     * @return self For method chaining
     */
    public function setId(BookingId $id): self
    {
        return $this->setAttribute('booking_id', $id->value());
    }

    /**
     * Gets the user who made the booking.
     *
     * @return UserId The user's ID
     */
    public function userId(): UserId
    {
        return new UserId($this->getAttributeValue('user_id'));
    }

    /**
     * Sets the user who made the booking.
     *
     * @param UserId $userId The user's ID
     * @return self For method chaining
     */
    public function setUserId(UserId $userId): self
    {
        return $this->setAttribute('user_id', $userId->value());
    }

    /**
     * Gets the room being booked.
     *
     * @return RoomId The room's ID
     */
    public function roomId(): RoomId
    {
        return new RoomId($this->getAttributeValue('room_id'));
    }

    /**
     * Sets the room being booked.
     *
     * @param RoomId $roomId The room's ID
     * @return self For method chaining
     */
    public function setRoomId(RoomId $roomId): self
    {
        return $this->setAttribute('room_id', $roomId->value());
    }

    /**
     * Gets the hotel where the room is located.
     *
     * @return HotelId The hotel's ID
     */
    public function hotelId(): HotelId
    {
        return new HotelId($this->getAttributeValue('hotel_id'));
    }

    /**
     * Sets the hotel where the room is located.
     *
     * @param HotelId $hotelId The hotel's ID
     * @return self For method chaining
     */
    public function setHotelId(HotelId $hotelId): self
    {
        return $this->setAttribute('hotel_id', $hotelId->value());
    }

    /**
     * Gets the check-in date of the booking.
     *
     * @return CheckInDate The check-in date
     */
    public function checkInDate(): CheckInDate
    {
        return new CheckInDate($this->getAttributeValue('check_in_date'));
    }

    /**
     * Sets the check-in date of the booking.
     *
     * @param CheckInDate $checkInDate The check-in date
     * @return self For method chaining
     */
    public function setCheckInDate(CheckInDate $checkInDate): self
    {
        return $this->setAttribute('check_in_date', $checkInDate->value());
    }

    /**
     * Gets the check-out date of the booking.
     *
     * @return CheckOutDate The check-out date
     */
    public function checkOutDate(): CheckOutDate
    {
        return new CheckOutDate($this->getAttributeValue('check_out_date'));
    }

    /**
     * Sets the check-out date of the booking.
     *
     * @param CheckOutDate $checkOutDate The check-out date
     * @return self For method chaining
     */
    public function setCheckOutDate(CheckOutDate $checkOutDate): self
    {
        return $this->setAttribute('check_out_date', $checkOutDate->value());
    }

    // Region relations
    /**
     * Gets the relationship with the hotel.
     *
     * @return BelongsTo The hotel relationship
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }
}
