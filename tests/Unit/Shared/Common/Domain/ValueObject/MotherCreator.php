<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

use Faker\Factory;
use Faker\Generator;

/**
 * Factory class for creating Faker instances.
 * 
 * This class provides a centralized way to create Faker instances
 * for generating test data across the test suite.
 */
final class MotherCreator
{
    public static function random(): Generator
    {
        return Factory::create();
    }
}
