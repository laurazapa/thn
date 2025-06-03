<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

/**
 * Class for generating random city names for testing.
 *
 * This class provides methods to generate random city names using Faker,
 * ensuring consistent test data generation across the test suite.
 */
final class CityMother
{
    public static function random(): string
    {
        return MotherCreator::random()->city;
    }
}
