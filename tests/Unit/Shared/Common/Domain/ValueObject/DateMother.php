<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

use Carbon\Carbon;

/**
 * Class for generating dates for testing.
 *
 * This class provides methods to generate dates for testing purposes,
 * ensuring consistent test data generation across the test suite.
 */
final class DateMother
{
    public static function randomFromToday(): Carbon
    {
        return Carbon::today();
    }
}
