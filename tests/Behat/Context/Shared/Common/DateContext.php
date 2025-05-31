<?php

namespace Behat\Context\Shared\Common;

use Behat\MinkExtension\Context\RawMinkContext;
use Carbon\Carbon;

class DateContext extends RawMinkContext
{
    /**
     * @Date
     * @Given Date is :dateString
     * @param string $dateString
     */
    public function dateIs(string $dateString): void
    {
        Carbon::setTestNow(Carbon::parse($dateString));
    }
}
