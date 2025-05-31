<?php

namespace Behat\Context\Bookings;

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Carbon\Carbon;
use Illuminate\Testing\Assert;
use Src\Bookings\Domain\Entity\Booking;
use Src\Bookings\Domain\ValueObject\BookingId;
use Src\Bookings\Domain\ValueObject\CheckInDate;
use Src\Bookings\Domain\ValueObject\CheckOutDate;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Users\Domain\ValueObject\UserId;

class BookingContext extends RawMinkContext
{
    /**
     * @Given there are the following bookings:
     * @param TableNode $rows
     */
    public function thereAreTheFollowingBookings(TableNode $rows): void
    {
        foreach ($rows->getColumnsHash() as $row) {
            $entity = new Booking()
                ->setId(new BookingId($row['Id']))
                ->setUserId(new UserId($row['UserId']))
                ->setRoomId(new RoomId($row['RoomId']))
                ->setHotelId(new HotelId($row['HotelId']))
                ->setCheckInDate(new CheckInDate(Carbon::parse($row['CheckIn'])))
                ->setCheckOutDate(new CheckOutDate(Carbon::parse($row['CheckOut'])));

            if (isset($row['CreatedAt'])) {
                $entity->setCreatedAt(Carbon::parse($row['CreatedAt']));
            }

            if (isset($row['UpdatedAt'])) {
                $entity->setUpdatedAt(Carbon::parse($row['UpdatedAt']));
            }

            $entity->save();
        }
    }

    /**
     * @Then there should exist the following bookings:
     * @param TableNode $rows
     */
    public function thereShouldExistTheFollowingBookings(TableNode $rows): void
    {
        foreach ($rows->getColumnsHash() as $row) {
            $query = Booking::query()
                ->where('user_id', $row['UserId'])
                ->where('room_id', $row['RoomId'])
                ->where('hotel_id', $row['HotelId'])
                ->where('check_in_date', Carbon::parse($row['CheckIn']))
                ->where('check_out_date', Carbon::parse($row['CheckOut']));
        }

        $numFound = $query->count();
        Assert::assertEquals($numFound, 1);
    }

    /**
     * @Then there should not exist the following bookings:
     * @param TableNode $rows
     */
    public function thereShouldNotExistTheFollowingBookings(TableNode $rows): void
    {
        foreach ($rows->getColumnsHash() as $row) {
            $query = Booking::query()
                ->where('user_id', $row['UserId'])
                ->where('room_id', $row['RoomId'])
                ->where('check_in_date', Carbon::parse($row['CheckIn']))
                ->where('check_out_date', Carbon::parse($row['CheckOut']));
        }

        $numFound = $query->count();
        Assert::assertEquals($numFound, 0);
    }

    /**
     * @BeforeScenario @Hotel
     */
    public function before(): void
    {
        Booking::query()->truncate();
    }
}
