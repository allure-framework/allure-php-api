<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\Model\AttachmentsAwareInterface;
use Qameta\Allure\Model\StorableInterface;

interface AttachmentsAwareStorableInterface extends AttachmentsAwareInterface, StorableInterface
{
}
