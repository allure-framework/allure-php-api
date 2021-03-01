<?php

namespace Qameta\Allure\Model;

/**
 * Interface ParametersAware
 * @package Qameta\Allure\Model
 */
interface ParametersAware
{
    /**
     * @return array<Parameter>
     */
    public function getParameters();
}
