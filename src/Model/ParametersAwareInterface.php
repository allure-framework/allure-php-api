<?php

namespace Qameta\Allure\Model;

interface ParametersAwareInterface
{
    /**
     * @return list<Parameter>
     */
    public function getParameters(): array;

    public function addParameters(Parameter ...$parameters): static;

    public function setParameters(Parameter ...$parameters): static;
}
