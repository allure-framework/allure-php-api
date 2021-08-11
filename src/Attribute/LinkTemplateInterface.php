<?php

declare(strict_types=1);

namespace Qameta\Allure\Attribute;

interface LinkTemplateInterface extends AttributeInterface
{

    public function buildUrl(?string $name): ?string;
}
