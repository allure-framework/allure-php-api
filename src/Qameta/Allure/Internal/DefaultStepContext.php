<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\AllureLifecycleInterface;
use Qameta\Allure\Model\Parameter;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\StepContextInterface;

final class DefaultStepContext implements StepContextInterface
{

    public function __construct(
        private AllureLifecycleInterface $lifecycle,
        private string $uuid,
    ) {
    }

    public function name(string $name): void
    {
        $this->lifecycle->updateStep(
            fn (StepResult $step) => $step->setName($name),
            $this->uuid,
        );
    }

    public function parameter(string $name, ?string $value): string
    {
        $param = new Parameter($name, $value);
        $this->lifecycle->updateStep(
            fn (StepResult $step) => $step->addParameters($param),
            $this->uuid,
        );

        return $value;
    }
}
