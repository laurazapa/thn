<?php

declare(strict_types=1);

namespace Src\Users\Domain\Entity;
use Illuminate\Database\Eloquent\Model;
use Src\Users\Domain\ValueObject\UserEmail;
use Src\Users\Domain\ValueObject\UserId;
use Src\Users\Domain\ValueObject\UserName;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $keyType = 'string';
    public $incrementing = false;

    // Region setters and getters
    public function id(): UserId
    {
        return new UserId($this->getAttributeValue('user_id'));
    }

    public function setId(UserId $id): self
    {
        return $this->setAttribute('user_id', $id->value());
    }

    public function name(): UserName
    {
        return new UserName($this->getAttributeValue('name'));
    }

    public function setName(UserName $name): self
    {
        return $this->setAttribute('name', $name->value());
    }

    public function email(): UserEmail
    {
        return new UserEmail($this->getAttributeValue('email'));
    }

    public function setEmail(UserEmail $email): self
    {
        return $this->setAttribute('email', $email->value());
    }
    // End region setters and getters
}
