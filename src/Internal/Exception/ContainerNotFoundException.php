<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal\Exception;

final class ContainerNotFoundException extends StorableNotFoundException
{

    protected function buildMessage(): string
    {
        return $this->buildStandardMessage('Container');
    }
}
