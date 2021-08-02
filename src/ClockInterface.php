<?php

declare(strict_types=1);

namespace Qameta\Allure;

use DateTimeImmutable;

interface ClockInterface
{

    public function now(): DateTimeImmutable;
}
