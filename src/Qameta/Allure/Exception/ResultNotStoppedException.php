<?php

declare(strict_types=1);

namespace Qameta\Allure\Exception;

use Qameta\Allure\Model\ResultType;
use Throwable;

final class ResultNotStoppedException extends ResultException
{

    public function __construct(
        ResultType $resultType,
        private string $uuid,
        ?Throwable $previous = null,
    ) {
        parent::__construct($resultType, $previous);
    }

    protected function buildMessage(): string
    {
        return "{$this->buildResultName()} with UUID {$this->uuid} was not stopped";
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
