<?php

namespace Behat\Context\Users;

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Carbon\Carbon;
use Src\Users\Domain\Entity\User;
use Src\Users\Domain\ValueObject\UserEmail;
use Src\Users\Domain\ValueObject\UserId;
use Src\Users\Domain\ValueObject\UserName;

class UserContext extends RawMinkContext
{
    /**
     * @Given there are the following users:
     * @param TableNode $rows
     */
    public function thereAreTheFollowingUsers(TableNode $rows): void
    {
        foreach ($rows->getColumnsHash() as $row) {
            $entity = new User()
                ->setId(new UserId($row['Id']))
                ->setName(new UserName($row['Name']))
                ->setEmail(new UserEmail($row['Email']));

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
     * @BeforeScenario @User
     */
    public function before(): void
    {
        User::query()->truncate();
    }
}
