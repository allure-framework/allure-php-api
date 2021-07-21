<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal\Exception;

use JetBrains\PhpStorm\Pure;

final class StepNotFoundException extends StorableNotFoundException
{

    #[Pure]
    protected function buildMessage(): string
    {
        return $this->buildStandardMessage('Step');
    }
}
