<?php

declare(strict_types=1);

namespace Qameta\Allure\Listener;

use Qameta\Allure\Model\ResultContainer;

interface ContainerListener extends LifecycleListener
{

    public function beforeContainerStart(ResultContainer $container): void;

    public function afterContainerStart(ResultContainer $container): void;

    public function beforeContainerUpdate(ResultContainer $container): void;

    public function afterContainerUpdate(ResultContainer $container): void;

    public function beforeContainerStop(ResultContainer $container): void;

    public function afterContainerStop(ResultContainer $container): void;

    public function beforeContainerWrite(ResultContainer $container): void;

    public function afterContainerWrite(ResultContainer $container): void;
}
