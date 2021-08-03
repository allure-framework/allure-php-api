<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

interface LabelsAwareInterface
{

    /**
     * @return list<Label>
     */
    public function getLabels(): array;

    public function addLabels(Label ...$labels): static;

    public function setLabels(Label ...$labels): static;
}
