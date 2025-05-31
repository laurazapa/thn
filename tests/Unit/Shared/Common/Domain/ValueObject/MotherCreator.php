<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

use Faker\Factory;
use Faker\Generator;

final class MotherCreator
{
    public static function random(): Generator
    {
        return Factory::create();
    }
}
