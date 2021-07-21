<?php

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;

/**
 * Interface StepsAware
 *
 * @package Qameta\Allure\Model
 */
interface StepsAware
{
    /**
     * @return list<StepResult>
     */
    #[Pure]
    public function getSteps(): array;

    public function addSteps(StepResult ...$steps);

    public function setSteps(StepResult ...$steps);
}
