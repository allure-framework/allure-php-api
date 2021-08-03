<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\Listener\AttachmentListenerInterface;
use Qameta\Allure\Listener\ContainerListenerInterface;
use Qameta\Allure\Listener\FixtureListenerInterface;
use Qameta\Allure\Listener\StepListenerInterface;
use Qameta\Allure\Listener\TestListenerInterface;

interface ListenerInterfaceInterfaceInterfaceNotifierInterface extends
    ContainerListenerInterface,
    FixtureListenerInterface,
    TestListenerInterface,
    StepListenerInterface,
    AttachmentListenerInterface
{
}
