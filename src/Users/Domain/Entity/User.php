<?php

declare(strict_types=1);

namespace Src\Users\Domain\Entity;

use Illuminate\Database\Eloquent\Model;
use Src\Users\Domain\ValueObject\UserEmail;
use Src\Users\Domain\ValueObject\UserId;
use Src\Users\Domain\ValueObject\UserName;

/**
 * User Entity.
 *
 * This class represents a user in the system. The entity encapsulates user data
 * and behavior, using value objects for type safety and domain validation.
 *
 * This class is currently coupled to Laravel's Model class for practical reasons:
 * 1. Direct access to Eloquent's powerful relationship system
 * 2. Easy integration with Laravel's seeding system
 * 3. Reduced development time and complexity
 *
 * While this approach works well for the current needs, a more DDD-compliant
 * approach would be to:
 * 1. Have a pure domain entity without framework dependencies
 * 2. Use a mapper/transformer to convert between domain entity and ORM model
 */
class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $keyType = 'string';
    public $incrementing = false;

    // Region setters and getters
    /**
     * Gets the user's unique identifier.
     *
     * @return UserId The user's UUID wrapped in a value object
     */
    public function id(): UserId
    {
        return new UserId($this->getAttributeValue('user_id'));
    }

    /**
     * Sets the user's unique identifier.
     *
     * @param UserId $id The user's UUID wrapped in a value object
     * @return self For method chaining
     */
    public function setId(UserId $id): self
    {
        return $this->setAttribute('user_id', $id->value());
    }

    /**
     * Gets the user's name.
     *
     * @return UserName The user's name wrapped in a value object
     */
    public function name(): UserName
    {
        return new UserName($this->getAttributeValue('name'));
    }

    /**
     * Sets the user's name.
     *
     * @param UserName $name The user's name wrapped in a value object
     * @return self For method chaining
     */
    public function setName(UserName $name): self
    {
        return $this->setAttribute('name', $name->value());
    }

    /**
     * Gets the user's email address.
     *
     * @return UserEmail The user's email wrapped in a value object
     */
    public function email(): UserEmail
    {
        return new UserEmail($this->getAttributeValue('email'));
    }

    /**
     * Sets the user's email address.
     *
     * @param UserEmail $email The user's email wrapped in a value object
     * @return self For method chaining
     */
    public function setEmail(UserEmail $email): self
    {
        return $this->setAttribute('email', $email->value());
    }
    // End region setters and getters
}
