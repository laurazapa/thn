<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Common\Domain\ValueObject;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Src\Shared\Common\Domain\ValueObject\DateRangeValueObject;
use Src\Shared\Common\Domain\ValueObject\DateValueObject;

class DateRangeValueObjectTest extends TestCase
{
    private function makeDate(string $date): DateValueObject
    {
        return new class(Carbon::parse($date)) extends DateValueObject {};
    }

    public function test_should_create_valid_date_range(): void
    {
        $start = $this->makeDate('2024-01-01');
        $end = $this->makeDate('2024-01-10');

        $range = new DateRangeValueObject($start, $end);

        $this->assertSame('2024-01-01', $range->startDate()->value()->toDateString());
        $this->assertSame('2024-01-10', $range->endDate()->value()->toDateString());
    }

    public function test_should_throw_exception_if_start_date_is_after_end_date(): void
    {
        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessageMatches('/Start date.*must be before end date/');

        $start = $this->makeDate('2024-01-10');
        $end = $this->makeDate('2024-01-01');

        new DateRangeValueObject($start, $end);
    }

    public function test_to_string_returns_expected_format(): void
    {
        $start = $this->makeDate('2024-03-01');
        $end = $this->makeDate('2024-03-05');

        $range = new DateRangeValueObject($start, $end);

        $this->assertSame('2024-03-01,2024-03-05', (string) $range);
    }
}
