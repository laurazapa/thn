<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

final class WordMother
{
    public static function random(): string
    {
        return MotherCreator::random()->word;
    }
}
