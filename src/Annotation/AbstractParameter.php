<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

abstract class AbstractParameter implements ParameterInterface
{

    public function __construct(
        private string $name,
        private ?string $value,
    ) {
    }

    final public function getName(): string
    {
        return $this->name;
    }

    final public function getValue(): ?string
    {
        return $this->value;
    }
}
