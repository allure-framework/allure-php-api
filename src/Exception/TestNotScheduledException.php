<?php

declare(strict_types=1);

namespace Qameta\Allure\Exception;

use Qameta\Allure\Model\ResultType;
use Throwable;

final class TestNotScheduledException extends ResultException
{

    public function __construct(
        private string $uuid,
        ?Throwable $previous = null,
    ) {
        parent::__construct(ResultType::test(), $previous);
    }

    protected function buildMessage(): string
    {
        return "{$this->buildResultName()} with UUID {$this->uuid} was not scheduled";
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
