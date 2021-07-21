<?php

declare(strict_types=1);

namespace Qameta\Allure\Exception;

use Qameta\Allure\Model\ResultType;
use Throwable;

final class ResultNotUpdatedException extends ResultException
{

    public function __construct(
        ResultType $resultType,
        private ?string $uuid,
        ?Throwable $previous = null,
    ) {
        parent::__construct(
            $resultType,
            $previous,
        );
    }

    protected function buildMessage(): string
    {
        $uuidText = isset($this->uuid)
            ? " with UUID {$this->uuid}"
            : '';
        return "{$this->buildResultName()}{$uuidText} was not updated";
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}