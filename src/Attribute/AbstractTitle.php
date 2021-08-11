<?php

declare(strict_types=1);

namespace Qameta\Allure\Attribute;

abstract class AbstractTitle implements TitleInterface
{
    public function __construct(private string $value)
    {
    }

    final public function getValue(): string
    {
        return $this->value;
    }
}
