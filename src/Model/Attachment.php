<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class Attachment implements JsonSerializable, Result
{
    use JsonSerializableTrait;

    #[Pure]
    public function __construct(
        private string $name,
        private string $source,
        private ?string $type = null,
    ) {
    }

    public function getResultType(): ResultType
    {
        return ResultType::attachment();
    }

    #[Pure]
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    #[Pure]
    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    #[Pure]
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }
}
