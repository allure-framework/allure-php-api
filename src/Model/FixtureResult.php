<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JsonSerializable;
use Qameta\Allure\Internal\AttachmentsAwareStorableInterface;
use Qameta\Allure\Internal\JsonSerializableTrait;
use Qameta\Allure\Internal\StepsAwareStorableInterface;

final class FixtureResult implements
    AttachmentsAwareStorableInterface,
    ParametersAwareInterface,
    StatusDetailsAwareInterface,
    StepsAwareStorableInterface,
    JsonSerializable,
    UuidAwareInterface,
    ResultInterface
{
    use ExecutableTrait;
    use JsonSerializableTrait;

    public function __construct(private string $uuid)
    {
    }

    public function getResultType(): ResultType
    {
        return ResultType::fixture();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return list<string>
     */
    protected function excludeFromSerialization(): array
    {
        return ['uuid'];
    }
}
