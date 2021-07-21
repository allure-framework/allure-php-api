<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use PHPUnit\Framework\TestCase;

use function floatval;
use function time;
use function usleep;

/**
 * @covers \Qameta\Allure\Internal\SystemClock
 */
class SystemClockTest extends TestCase
{

    public function testTime_CalledTwiceAfterPeriod_ResultsDifferenceIsSameAsPeriod(): void
    {
        $clock = new SystemClock();

        $timeBase = time();
        $firstValue = floatval($clock->now()->format('U.u')) - $timeBase;
        usleep(50000); // sleep for 0.05 s
        $secondValue = floatval($clock->now()->format('U.u')) - $timeBase;
        self::assertEqualsWithDelta(0.05, $secondValue - $firstValue, 0.02);
    }
}
