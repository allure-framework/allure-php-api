<?php

declare(strict_types=1);

namespace Qameta\Allure\Listener;

interface LifecycleNotifier extends
    ContainerListener,
    FixtureListener,
    TestListener,
    StepListener,
    AttachmentListener
{
}
