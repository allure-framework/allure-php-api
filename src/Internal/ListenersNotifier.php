<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Psr\Log\LoggerInterface;
use Qameta\Allure\Exception\ResultNotListenedException;
use Qameta\Allure\Listener\AttachmentListener;
use Qameta\Allure\Listener\ContainerListener;
use Qameta\Allure\Listener\FixtureListener;
use Qameta\Allure\Listener\LifecycleListener;
use Qameta\Allure\Listener\StepListener;
use Qameta\Allure\Listener\TestListener;
use Qameta\Allure\Model\Attachment;
use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\ResultType;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;
use Throwable;

final class ListenersNotifier implements LifecycleNotifier
{
    use ProcessExceptionTrait;

    /**
     * @var list<LifecycleListener>
     */
    private array $listeners;

    /**
     * @var list<ContainerListener>
     */
    private array $containerListeners = [];

    /**
     * @var list<FixtureListener>
     */
    private array $fixtureListeners = [];

    /**
     * @var list<TestListener>
     */
    private array $testListeners = [];

    public function __construct(
        LoggerInterface $logger,
        LifecycleListener ...$listeners,
    ) {
        $this->logger = $logger;
        $this->listeners = $listeners;
    }

    public function beforeContainerStart(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListener $listener) => $listener->beforeContainerStart($container),
        );
    }

    public function afterContainerStart(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListener $listener) => $listener->afterContainerStart($container),
        );
    }

    public function beforeContainerUpdate(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListener $listener) => $listener->beforeContainerUpdate($container),
        );
    }

    public function afterContainerUpdate(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListener $listener) => $listener->afterContainerUpdate($container),
        );
    }

    public function beforeContainerStop(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListener $listener) => $listener->beforeContainerStop($container),
        );
    }

    public function afterContainerStop(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListener $listener) => $listener->afterContainerStop($container),
        );
    }

    public function beforeContainerWrite(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListener $listener) => $listener->beforeContainerWrite($container),
        );
    }

    public function afterContainerWrite(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListener $listener) => $listener->afterContainerWrite($container),
        );
    }

    public function beforeFixtureStart(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListener $listener) => $listener->beforeFixtureStart($fixture),
        );
    }

    public function afterFixtureStart(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListener $listener) => $listener->afterFixtureStart($fixture),
        );
    }

    public function beforeFixtureUpdate(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListener $listener) => $listener->beforeFixtureUpdate($fixture),
        );
    }

    public function afterFixtureUpdate(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListener $listener) => $listener->afterFixtureUpdate($fixture),
        );
    }

    public function beforeFixtureStop(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListener $listener) => $listener->beforeFixtureStop($fixture),
        );
    }

    public function afterFixtureStop(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListener $listener) => $listener->afterFixtureStop($fixture),
        );
    }

    public function beforeTestSchedule(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->beforeTestSchedule($test),
        );
    }

    public function afterTestSchedule(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->afterTestSchedule($test),
        );
    }

    public function beforeTestStart(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->beforeTestStart($test),
        );
    }

    public function afterTestStart(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->afterTestStart($test),
        );
    }

    public function beforeTestUpdate(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->beforeTestUpdate($test),
        );
    }

    public function afterTestUpdate(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->afterTestUpdate($test),
        );
    }

    public function beforeTestStop(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->beforeTestStop($test),
        );
    }

    public function afterTestStop(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->afterTestStop($test),
        );
    }

    public function beforeTestWrite(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->beforeTestWrite($test),
        );
    }

    public function afterTestWrite(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListener $listener) => $listener->afterTestWrite($test),
        );
    }

    public function beforeStepStart(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListener $listener) => $listener->beforeStepStart($step),
        );
    }

    public function afterStepStart(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListener $listener) => $listener->afterStepStart($step),
        );
    }

    public function beforeStepUpdate(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListener $listener) => $listener->beforeStepUpdate($step),
        );
    }

    public function afterStepUpdate(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListener $listener) => $listener->afterStepUpdate($step),
        );
    }

    public function beforeStepStop(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListener $listener) => $listener->beforeStepStop($step),
        );
    }

    public function afterStepStop(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListener $listener) => $listener->afterStepStop($step),
        );
    }

    public function beforeAttachmentWrite(Attachment $attachment): void
    {
        $this->forEachAttachmentListener(
            fn (AttachmentListener $listener) => $listener->beforeAttachmentWrite($attachment),
        );
    }

    public function afterAttachmentWrite(Attachment $attachment): void
    {
        $this->forEachAttachmentListener(
            fn (AttachmentListener $listener) => $listener->afterAttachmentWrite($attachment),
        );
    }

    private function forEachContainerListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof ContainerListener) {
                $this->runNotification(ResultType::container(), $callable, $listener);
            }
        }
    }

    private function forEachFixtureListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof FixtureListener) {
                $this->runNotification(ResultType::fixture(), $callable, $listener);
            }
        }
    }

    private function forEachTestListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof TestListener) {
                $this->runNotification(ResultType::test(), $callable, $listener);
            }
        }
    }

    private function forEachStepListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof StepListener) {
                $this->runNotification(ResultType::step(), $callable, $listener);
            }
        }
    }

    private function forEachAttachmentListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof AttachmentListener) {
                $this->runNotification(ResultType::attachment(), $callable, $listener);
            }
        }
    }

    private function runNotification(ResultType $resultType, callable $callable, LifecycleListener $listener): void
    {
        try {
            $callable($listener);
        } catch (Throwable $e) {
            $this->processException(
                new ResultNotListenedException($resultType, $listener, $e),
            );
        }
    }
}
