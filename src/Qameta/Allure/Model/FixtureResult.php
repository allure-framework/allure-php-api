<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class FixtureResult implements
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

    #[Pure]
    public function __construct(private string $uuid)
    {
    }

    public function getResultType(): ResultType
    {
        return ResultType::fixture();
    }

    #[Pure]
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
