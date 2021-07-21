<?php

declare(strict_types=1);

namespace Qameta\Allure\Exception;

use Qameta\Allure\Model\ResultType;
use RuntimeException;
use Throwable;

abstract class ResultException extends RuntimeException
{

    public function __construct(
        private ResultType $resultType,
        ?Throwable $previous = null,
    ) {
        parent::__construct($this->buildMessage(), 0, $previous);
    }

    abstract protected function buildMessage(): string;

    final public function getResultType(): ResultType
    {
        return $this->resultType;
    }

    final protected function buildResultName(): string
    {
        return match ($this->resultType) {
            ResultType::fixture() => 'Fixture',
            ResultType::test() => 'Test',
            ResultType::step() => 'Step',
            default => '<unknown result>',
        };
    }
}
