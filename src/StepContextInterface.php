<?php

declare(strict_types=1);

namespace Qameta\Allure;

interface StepContextInterface
{

    public function name(string $name): void;

    public function parameter(string $name, ?string $value): ?string;
}
