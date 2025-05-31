<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

/**
 * Factory class for generating random UUIDs for testing.
 * 
 * This class provides methods to generate random UUIDs using Faker,
 * ensuring consistent test data generation across the test suite.
 */
final class UuidMother
{
    public static function random(): string
    {
        return MotherCreator::random()->unique()->uuid;
    }
}
