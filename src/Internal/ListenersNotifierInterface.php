<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Psr\Log\LoggerInterface;
use Qameta\Allure\Exception\ResultNotListenedException;
use Qameta\Allure\Listener\AttachmentListenerInterface;
use Qameta\Allure\Listener\ContainerListenerInterface;
use Qameta\Allure\Listener\FixtureListenerInterface;
use Qameta\Allure\Listener\LifecycleListenerInterface;
use Qameta\Allure\Listener\StepListenerInterface;
use Qameta\Allure\Listener\TestListenerInterface;
use Qameta\Allure\Model\Attachment;
use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\ResultType;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;
use Throwable;

use function array_values;

final class ListenersNotifierInterface implements ListenerInterfaceInterfaceInterfaceNotifierInterface
{
    use ProcessExceptionTrait;

    /**
     * @var list<LifecycleListenerInterface>
     */
    private array $listeners;

    /**
     * @var list<ContainerListenerInterface>
     */
    private array $containerListeners = [];

    /**
     * @var list<FixtureListenerInterface>
     */
    private array $fixtureListeners = [];

    /**
     * @var list<TestListenerInterface>
     */
    private array $testListeners = [];

    public function __construct(
        LoggerInterface $logger,
        LifecycleListenerInterface ...$listeners,
    ) {
        $this->logger = $logger;
        $this->listeners = array_values($listeners);
    }

    public function beforeContainerStart(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListenerInterface $listener) => $listener->beforeContainerStart($container),
        );
    }

    public function afterContainerStart(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListenerInterface $listener) => $listener->afterContainerStart($container),
        );
    }

    public function beforeContainerUpdate(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListenerInterface $listener) => $listener->beforeContainerUpdate($container),
        );
    }

    public function afterContainerUpdate(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListenerInterface $listener) => $listener->afterContainerUpdate($container),
        );
    }

    public function beforeContainerStop(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListenerInterface $listener) => $listener->beforeContainerStop($container),
        );
    }

    public function afterContainerStop(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListenerInterface $listener) => $listener->afterContainerStop($container),
        );
    }

    public function beforeContainerWrite(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListenerInterface $listener) => $listener->beforeContainerWrite($container),
        );
    }

    public function afterContainerWrite(ResultContainer $container): void
    {
        $this->forEachContainerListener(
            fn (ContainerListenerInterface $listener) => $listener->afterContainerWrite($container),
        );
    }

    public function beforeFixtureStart(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListenerInterface $listener) => $listener->beforeFixtureStart($fixture),
        );
    }

    public function afterFixtureStart(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListenerInterface $listener) => $listener->afterFixtureStart($fixture),
        );
    }

    public function beforeFixtureUpdate(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListenerInterface $listener) => $listener->beforeFixtureUpdate($fixture),
        );
    }

    public function afterFixtureUpdate(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListenerInterface $listener) => $listener->afterFixtureUpdate($fixture),
        );
    }

    public function beforeFixtureStop(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListenerInterface $listener) => $listener->beforeFixtureStop($fixture),
        );
    }

    public function afterFixtureStop(FixtureResult $fixture): void
    {
        $this->forEachFixtureListener(
            fn (FixtureListenerInterface $listener) => $listener->afterFixtureStop($fixture),
        );
    }

    public function beforeTestSchedule(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->beforeTestSchedule($test),
        );
    }

    public function afterTestSchedule(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->afterTestSchedule($test),
        );
    }

    public function beforeTestStart(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->beforeTestStart($test),
        );
    }

    public function afterTestStart(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->afterTestStart($test),
        );
    }

    public function beforeTestUpdate(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->beforeTestUpdate($test),
        );
    }

    public function afterTestUpdate(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->afterTestUpdate($test),
        );
    }

    public function beforeTestStop(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->beforeTestStop($test),
        );
    }

    public function afterTestStop(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->afterTestStop($test),
        );
    }

    public function beforeTestWrite(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->beforeTestWrite($test),
        );
    }

    public function afterTestWrite(TestResult $test): void
    {
        $this->forEachTestListener(
            fn (TestListenerInterface $listener) => $listener->afterTestWrite($test),
        );
    }

    public function beforeStepStart(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListenerInterface $listener) => $listener->beforeStepStart($step),
        );
    }

    public function afterStepStart(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListenerInterface $listener) => $listener->afterStepStart($step),
        );
    }

    public function beforeStepUpdate(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListenerInterface $listener) => $listener->beforeStepUpdate($step),
        );
    }

    public function afterStepUpdate(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListenerInterface $listener) => $listener->afterStepUpdate($step),
        );
    }

    public function beforeStepStop(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListenerInterface $listener) => $listener->beforeStepStop($step),
        );
    }

    public function afterStepStop(StepResult $step): void
    {
        $this->forEachStepListener(
            fn (StepListenerInterface $listener) => $listener->afterStepStop($step),
        );
    }

    public function beforeAttachmentWrite(Attachment $attachment): void
    {
        $this->forEachAttachmentListener(
            fn (AttachmentListenerInterface $listener) => $listener->beforeAttachmentWrite($attachment),
        );
    }

    public function afterAttachmentWrite(Attachment $attachment): void
    {
        $this->forEachAttachmentListener(
            fn (AttachmentListenerInterface $listener) => $listener->afterAttachmentWrite($attachment),
        );
    }

    private function forEachContainerListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof ContainerListenerInterface) {
                $this->runNotification(ResultType::container(), $callable, $listener);
            }
        }
    }

    private function forEachFixtureListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof FixtureListenerInterface) {
                $this->runNotification(ResultType::fixture(), $callable, $listener);
            }
        }
    }

    private function forEachTestListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof TestListenerInterface) {
                $this->runNotification(ResultType::test(), $callable, $listener);
            }
        }
    }

    private function forEachStepListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof StepListenerInterface) {
                $this->runNotification(ResultType::step(), $callable, $listener);
            }
        }
    }

    private function forEachAttachmentListener(callable $callable): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof AttachmentListenerInterface) {
                $this->runNotification(ResultType::attachment(), $callable, $listener);
            }
        }
    }

    private function runNotification(ResultType $resultType, callable $callable, LifecycleListenerInterface $listener): void
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
