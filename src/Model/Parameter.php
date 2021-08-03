<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class Parameter implements JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        private string $name,
        private ?string $value = null,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
