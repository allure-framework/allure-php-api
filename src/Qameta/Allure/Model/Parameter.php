<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Qameta\Allure\Internal\JsonSerializableTrait;

final class Parameter implements JsonSerializable
{
    use JsonSerializableTrait;

    #[Pure]
    public function __construct(
        private string $name,
        private ?string $value = null,
    ) {
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
