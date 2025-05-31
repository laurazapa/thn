<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

/**
 * Factory class for generating random country names for testing.
 * 
 * This class provides methods to generate random country names using Faker,
 * ensuring consistent test data generation across the test suite.
 */
final class CountryMother
{
    public static function random(): string
    {
        return MotherCreator::random()->country;
    }
}
