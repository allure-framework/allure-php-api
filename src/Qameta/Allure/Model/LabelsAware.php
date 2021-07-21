<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;

interface LabelsAware
{

    /**
     * @return list<Label>
     */
    #[Pure]
    public function getLabels(): array;

    public function addLabels(Label ...$labels);

    public function setLabels(Label ...$labels);
}
