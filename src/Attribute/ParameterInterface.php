<?php

declare(strict_types=1);

namespace Qameta\Allure\Attribute;

interface ParameterInterface extends AttributeInterface
{

    public function getName(): string;

    public function getValue(): ?string;
}
