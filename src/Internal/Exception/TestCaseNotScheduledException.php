<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal\Exception;

final class TestCaseNotScheduledException extends StorableNotFoundException
{

    protected function buildMessage(): string
    {
        return $this->buildStandardMessage('Test case', 'is not scheduled');
    }
}
