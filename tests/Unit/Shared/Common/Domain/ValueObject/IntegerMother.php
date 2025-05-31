<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

final class IntegerMother
{
    public static function between(int $min, int $max = 99999999): int
    {
        return MotherCreator::random()->numberBetween($min, $max);
    }

    public static function random(): int
    {
        return self::between(1);
    }
}
