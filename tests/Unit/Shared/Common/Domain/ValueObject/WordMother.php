<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

/**
 * Factory class for generating random words for testing.
 * 
 * This class provides methods to generate random words using Faker,
 * ensuring consistent test data generation across the test suite.
 */
final class WordMother
{
    public static function random(): string
    {
        return MotherCreator::random()->word;
    }
}
