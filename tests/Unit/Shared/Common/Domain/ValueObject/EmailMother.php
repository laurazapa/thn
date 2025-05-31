<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

/**
 * Factory class for generating random email addresses for testing.
 * 
 * This class provides methods to generate random email addresses using Faker,
 * ensuring consistent test data generation across the test suite.
 */
final class EmailMother
{
    public static function random(): string
    {
        return MotherCreator::random()->email;
    }
}
