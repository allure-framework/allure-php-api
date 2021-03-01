<?php

namespace Qameta\Allure\Model;

/**
 * Interface StepsAware
 * @package Qameta\Allure\Model
 */
interface StepsAware
{
    /**
     * @return array<StepResult>
     */
    public function getSteps();
}
