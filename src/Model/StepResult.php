<?php

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class StepResult implements
    AttachmentsAware,
    ParametersAware,
    StatusDetailsAware,
    StepsAware,
    Storable,
    JsonSerializable,
    UuidAware,
    Result
{
    use ExecutableTrait;
    use JsonSerializableTrait;

    public function __construct(private string $uuid)
    {
    }

    public function getResultType(): ResultType
    {
        return ResultType::step();
    }

    #[Pure]
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return list<string>
     */
    #[Pure]
    protected function excludeFromSerialization(): array
    {
        return ['uuid'];
    }
}
