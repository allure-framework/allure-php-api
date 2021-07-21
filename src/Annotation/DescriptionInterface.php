<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

interface DescriptionInterface
{
    public function getValue(): string;

    public function isHtml(): bool;
}
