<?php

declare(strict_types=1);

namespace Qameta\Allure\Attribute;

interface TitleInterface extends AttributeInterface
{

    public function getValue(): string;
}
