<?php

namespace Behat\Context\Hotels;

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Carbon\Carbon;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Rooms\Domain\Entity\Room;
use Src\Hotels\Rooms\Domain\ValueObject\RoomId;
use Src\Hotels\Rooms\Domain\ValueObject\RoomLabel;

/**
 * Behat context for managing room-related scenarios.
 *
 * This context provides step definitions for:
 * - Setting up room test data
 * - Cleaning up room data between scenarios
 *
 * It handles the creation of rooms in the system
 * for acceptance testing purposes.
 */
class RoomContext extends RawMinkContext
{
    /**
     * @Given there are the following rooms:
     * @param TableNode $rows
     */
    public function thereAreTheFollowingRooms(TableNode $rows): void
    {
        foreach ($rows->getColumnsHash() as $row) {
            $entity = new Room()
                ->setId(new RoomId($row['Id']))
                ->setHotelId(new HotelId($row['HotelId']))
                ->setRoomLabel(new RoomLabel($row['Label']));

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
     * @BeforeScenario @Room
     */
    public function before(): void
    {
        Room::query()->truncate();
    }
}
