<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Src\Shared\Common\Domain\ValueObject\EmailValueObject;

/**
 * Concrete implementation of EmailValueObject for testing purposes.
 * 
 * This class extends the abstract EmailValueObject to allow testing
 * its functionality in a concrete context.
 */
final class TestEmailValueObject extends EmailValueObject {}

/**
 * Test suite for the EmailValueObject.
 * 
 * This test suite verifies the behavior of the EmailValueObject when:
 * - Creating valid email addresses
 * - Handling invalid email formats
 * - Validating email format rules
 */
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
