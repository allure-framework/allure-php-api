<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use DateTimeImmutable;

use function explode;
use function microtime;
use function round;

final class SystemClock implements ClockInterface
{

    public function now(): DateTimeImmutable
    {
        [$mSec, $sec] = explode(' ', microtime(false));

        $mSec = (int) round($mSec * 1000000);

        return (new DateTimeImmutable("@{$sec}"))->modify("+{$mSec} microsecond");
    }
}