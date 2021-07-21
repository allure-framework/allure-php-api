<?php

declare(strict_types=1);

namespace Qameta\Allure\Annotation;

interface LabelInterface
{

    public function getName(): string;

    public function getValue(): ?string;
}
