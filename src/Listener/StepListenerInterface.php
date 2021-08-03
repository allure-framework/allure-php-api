<?php

declare(strict_types=1);

namespace Qameta\Allure\Listener;

use Qameta\Allure\Model\StepResult;

interface StepListenerInterface
{

    public function beforeStepStart(StepResult $step): void;

    public function afterStepStart(StepResult $step): void;

    public function beforeStepUpdate(StepResult $step): void;

    public function afterStepUpdate(StepResult $step): void;

    public function beforeStepStop(StepResult $step): void;

    public function afterStepStop(StepResult $step): void;
}
