<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Src\Shared\Common\Domain\ValueObject\UuidValueObject;

class UuidValueObjectTest extends TestCase
{
    public function test_should_create_valid_uuid(): void
    {
        $uuid = RamseyUuid::uuid4()->toString();
        $vo = new UuidValueObject($uuid);

        $this->assertSame($uuid, $vo->value());
        $this->assertSame($uuid, (string) $vo);
    }

    public function test_should_throw_exception_for_invalid_uuid(): void
    {
        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessageMatches('/does not allow the value/');

        new UuidValueObject('invalid-uuid');
    }
}
