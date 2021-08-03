<?php

namespace Qameta\Allure\Model;

interface StepsAwareInterface
{
    /**
     * @return list<StepResult>
     */
    public function getSteps(): array;

    public function addSteps(StepResult ...$steps): static;

    public function setSteps(StepResult ...$steps): static;
}
