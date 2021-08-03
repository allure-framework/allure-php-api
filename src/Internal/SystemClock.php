<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use DateTimeImmutable;
use Qameta\Allure\ClockInterface;

use function explode;
use function microtime;
use function round;

/**
 * @internal
 */
final class SystemClock implements ClockInterface
{

    public function now(): DateTimeImmutable
    {
        [$mSec, $sec] = explode(' ', microtime(false));

        $mSec = (int) round(1000000 * (float) $mSec);

        return (new DateTimeImmutable("@{$sec}"))->modify("+{$mSec} microsecond");
    }
}
