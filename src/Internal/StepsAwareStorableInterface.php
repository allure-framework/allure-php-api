<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\Model\StepsAwareInterface;
use Qameta\Allure\Model\StorableInterface;

interface StepsAwareStorableInterface extends StepsAwareInterface, StorableInterface
{
}
