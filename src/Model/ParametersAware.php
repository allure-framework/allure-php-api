<?php

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;

/**
 * Interface ParametersAware
 *
 * @package Qameta\Allure\Model
 */
interface ParametersAware
{
    /**
     * @return list<Parameter>
     */
    #[Pure]
    public function getParameters(): array;

    public function addParameters(Parameter ...$parameters): static;

    public function setParameters(Parameter ...$parameters): static;
}
