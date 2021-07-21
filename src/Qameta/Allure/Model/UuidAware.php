<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;

interface UuidAware extends Storable
{

    #[Pure]
    public function getUuid(): string;
}
