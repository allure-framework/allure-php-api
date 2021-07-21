<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use DateTimeImmutable;

interface ClockInterface
{

    public function now(): DateTimeImmutable;
}
