<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

use JetBrains\PhpStorm\Pure;

interface StatusDetailsAware
{

    #[Pure]
    public function getStatusDetails(): ?StatusDetails;

    public function setStatusDetails(?StatusDetails $statusDetails): static;
}
