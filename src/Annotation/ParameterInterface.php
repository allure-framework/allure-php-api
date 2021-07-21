<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

interface ParameterInterface
{

    public function getName(): string;

    public function getValue(): ?string;
}
