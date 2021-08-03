<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

interface StatusDetailsAwareInterface
{

    public function getStatusDetails(): ?StatusDetails;

    public function setStatusDetails(?StatusDetails $statusDetails): static;
}
