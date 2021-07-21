<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

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
