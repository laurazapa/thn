<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

use Carbon\Carbon;

final class DateMother
{
    public static function randomFromToday(): Carbon
    {
        return Carbon::today();
    }
}
