<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Domain\Entity;

use Src\Users\Domain\Entity\User;
use Src\Users\Domain\ValueObject\UserEmail;
use Src\Users\Domain\ValueObject\UserId;
use Src\Users\Domain\ValueObject\UserName;
use Tests\Unit\Shared\Common\Domain\ValueObject\EmailMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\UuidMother;
use Tests\Unit\Shared\Common\Domain\ValueObject\WordMother;

/**
 * Class for creating User test instances.
 *
 * This class provides methods to create User entities with random or specific values
 * for testing purposes. It ensures consistent test data generation across the test suite.
 */
class UserMother
{
    public static function create(
        ?UserId $userId = null,
        ?UserName $name = null,
        ?UserEmail $email = null,
    ): User {
        return new User()
            ->setId($userId ?? new UserId(UuidMother::random()))
            ->setName($name ?? new UserName(WordMother::random()))
            ->setEmail($email ?? new UserEmail(EmailMother::random()));
    }
}
