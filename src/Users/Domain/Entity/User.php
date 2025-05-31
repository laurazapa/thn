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
 * This class represents a user in the system. It extends the Eloquent Model
 * and provides value object wrappers for its attributes.
 *
 * The user is identified by a unique UUID and has basic information
 * like name and email.
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
