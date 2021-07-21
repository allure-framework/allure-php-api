<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal\Exception;

use JetBrains\PhpStorm\Pure;

final class StepsAwareNotFoundException extends StorableNotFoundException
{

    #[Pure]
    protected function buildMessage(): string
    {
        return $this->buildStandardMessage('Test case, step or fixture');
    }
}
