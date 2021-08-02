<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\Listener\AttachmentListener;
use Qameta\Allure\Listener\ContainerListener;
use Qameta\Allure\Listener\FixtureListener;
use Qameta\Allure\Listener\StepListener;
use Qameta\Allure\Listener\TestListener;

interface LifecycleNotifier extends
    ContainerListener,
    FixtureListener,
    TestListener,
    StepListener,
    AttachmentListener
{
}
