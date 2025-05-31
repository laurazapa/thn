<?php

namespace Behat\Context\Hotels;

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Carbon\Carbon;
use Src\Hotels\Hotels\Domain\Entity\Hotel;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCity;
use Src\Hotels\Hotels\Domain\ValueObject\HotelCountry;
use Src\Hotels\Hotels\Domain\ValueObject\HotelId;
use Src\Hotels\Hotels\Domain\ValueObject\HotelName;

class HotelContext extends RawMinkContext
{
    /**
     * @Given there are the following hotels:
     * @param TableNode $rows
     */
    public function thereAreTheFollowingHotels(TableNode $rows): void
    {
        foreach ($rows->getColumnsHash() as $row) {
            $entity = new Hotel()
                ->setId(new HotelId($row['Id']))
                ->setName(new HotelName($row['Name']))
                ->setCity(new HotelCity($row['City']))
                ->setCountry(new HotelCountry($row['Country']));

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
     * @BeforeScenario @Hotel
     */
    public function before(): void
    {
        Hotel::query()->truncate();
    }
}
