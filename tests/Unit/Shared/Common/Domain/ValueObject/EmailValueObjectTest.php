<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Src\Shared\Common\Domain\ValueObject\EmailValueObject;

// Anonymous class to test abstract VO
final class TestEmailValueObject extends EmailValueObject {}

class EmailValueObjectTest extends TestCase
{
    public function test_should_create_email_value_object_with_valid_email(): void
    {
        $email = new TestEmailValueObject('test@example.com');

        $this->assertSame('test@example.com', $email->value());
    }

    public function test_should_throw_exception_for_invalid_email(): void
    {
        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessageMatches('/does not allow the value/');

        new TestEmailValueObject('not-an-email');
    }
}
