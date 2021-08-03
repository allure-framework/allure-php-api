<?php

declare(strict_types=1);

namespace Qameta\Allure\Model;

interface UuidAwareInterface extends StorableInterface
{

    public function getUuid(): string;
}
