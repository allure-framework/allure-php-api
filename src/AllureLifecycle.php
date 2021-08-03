<?php

namespace Qameta\Allure;

use Psr\Log\LoggerInterface;
use Qameta\Allure\Exception\ActiveFixtureNotFoundException;
use Qameta\Allure\Exception\ActiveStepNotFoundException;
use Qameta\Allure\Exception\ActiveTestNotFoundException;
use Qameta\Allure\Exception\ActiveAttachmentContextNotFoundException;
use Qameta\Allure\Exception\AttachmentNotAddedException;
use Qameta\Allure\Exception\ResultNotStartedException;
use Qameta\Allure\Exception\ResultNotStoppedException;
use Qameta\Allure\Exception\ResultNotUpdatedException;
use Qameta\Allure\Exception\TestNotScheduledException;
use Qameta\Allure\Exception\ResultNotWrittenException;
use Qameta\Allure\Internal\AllureStorageInterface;
use Qameta\Allure\Internal\ProcessExceptionTrait;
use Qameta\Allure\Internal\ListenerInterfaceInterfaceInterfaceNotifierInterface;
use Qameta\Allure\Model\Attachment;
use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\ResultType;
use Qameta\Allure\Model\Stage;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;
use Throwable;

use function array_pop;
use function count;
use function in_array;

final class AllureLifecycle implements AllureLifecycleInterface
{
    use ProcessExceptionTrait;

    /**
     * @var list<string>
     */
    private array $contexts = [];

    public function __construct(
        LoggerInterface $logger,
        private ClockInterface $clock,
        private AllureResultsWriterInterface $resultsWriter,
        private ListenerInterfaceInterfaceInterfaceNotifierInterface $notifier,
        private AllureStorageInterface $storage,
    ) {
        $this->logger = $logger;
    }

    public function startTestContainer(ResultContainer $container, ?string $parentUuid = null): void
    {
        $this->notifier->beforeContainerStart($container);
        try {
            if (isset($parentUuid)) {
                $this
                    ->storage
                    ->getContainer($parentUuid)
                    ->addChildren($container->getUuid());
            }
            $this->storage->set(
                $container->setStart($this->clock->now()),
            );
        } catch (Throwable $e) {
            $this->processException(
                new ResultNotStartedException($container->getResultType(), $container->getUuid(), $e),
            );
        }
        $this->notifier->afterContainerStart($container);
    }

    /**
     * @param string   $uuid
     * @param callable $update
     */
    public function updateTestContainer(string $uuid, callable $update): void
    {
        try {
            $container = $this->storage->getContainer($uuid);
        } catch (Throwable $e) {
            $this->processException(new ResultNotUpdatedException(ResultType::container(), $uuid, $e));

            return;
        }
        $this->notifier->beforeContainerUpdate($container);
        try {
            $update($container);
        } catch (Throwable $e) {
            $this->processException(
                new ResultNotUpdatedException($container->getResultType(), $container->getUuid(), $e),
            );
        }
        $this->notifier->afterContainerUpdate($container);
    }

    public function stopTestContainer(string $uuid): void
    {
        try {
            $container = $this->storage->getContainer($uuid);
        } catch (Throwable $e) {
            $this->processException(
                new ResultNotStoppedException(ResultType::container(), $uuid, $e),
            );

            return;
        }
        $this->notifier->beforeContainerStop($container);
        try {
            $container->setStop($this->clock->now());
        } catch (Throwable $e) {
            $this->processException(
                new ResultNotStoppedException($container->getResultType(), $container->getUuid(), $e),
            );
        }
        $this->notifier->afterContainerStop($container);
    }

    public function writeTestContainer(string $uuid): void
    {
        try {
            $container = $this->storage->getContainer($uuid);
        } catch (Throwable $e) {
            $this->processException(
                new ResultNotWrittenException(ResultType::container(), $uuid, $e),
            );

            return;
        }
        $this->notifier->beforeContainerWrite($container);
        try {
            $this->resultsWriter->writeContainer($container);
            $this->storage->unset($container->getUuid());
        } catch (Throwable $e) {
            $this->processException(
                new ResultNotWrittenException($container->getResultType(), $container->getUuid(), $e),
            );
        }
        $this->notifier->afterContainerWrite($container);
    }

    public function startSetUpFixture(string $containerUuid, FixtureResult $fixture): void
    {
        $this->notifier->beforeFixtureStart($fixture);
        try {
            $this
                ->storage
                ->getContainer($containerUuid)
                ->addSetUps($fixture);
            $this->startFixture($fixture);
        } catch (Throwable $e) {
            $this->processException(new ResultNotStartedException($fixture->getResultType(), $fixture->getUuid(), $e));
        }
        $this->notifier->afterFixtureStart($fixture);
    }

    public function startTearDownFixture(string $containerUuid, FixtureResult $fixture): void
    {
        $this->notifier->beforeFixtureStart($fixture);
        try {
            $this
                ->storage
                ->getContainer($containerUuid)
                ->addTearDowns($fixture);
            $this->startFixture($fixture);
        } catch (Throwable $e) {
            $this->processException(new ResultNotStartedException($fixture->getResultType(), $fixture->getUuid(), $e));
        }
        $this->notifier->afterFixtureStart($fixture);
    }

    private function startFixture(FixtureResult $fixture): void
    {
        $this->storage->set(
            $fixture
                ->setStage(Stage::running())
                ->setStart($this->clock->now())
        );
        $this->contexts = [$fixture->getUuid()];
    }

    public function updateFixture(callable $update, ?string $uuid = null): void
    {
        try {
            $fixture = $this->storage->getFixture(
                $uuid ?? $this->findRootContext() ?? throw new ActiveFixtureNotFoundException(),
            );
        } catch (Throwable $e) {
            $this->processException(new ResultNotUpdatedException(ResultType::fixture(), $uuid, $e));

            return;
        }
        $this->notifier->beforeFixtureUpdate($fixture);
        try {
            $update($fixture);
        } catch (Throwable $e) {
            $this->processException(new ResultNotUpdatedException($fixture->getResultType(), $fixture->getUuid(), $e));
        }
        $this->notifier->afterFixtureUpdate($fixture);
    }

    public function stopFixture(string $uuid): void
    {
        try {
            $fixture = $this->storage->getFixture(
                $this->findRootContext($uuid) ?? throw new ActiveFixtureNotFoundException(),
            );
        } catch (Throwable $e) {
            $this->processException(new ResultNotStoppedException(ResultType::fixture(), $uuid, $e));

            return;
        }
        $this->notifier->beforeFixtureStop($fixture);
        try {
            $fixture
                ->setStage(Stage::finished())
                ->setStop($this->clock->now());
            $this->storage->unset($fixture->getUuid());
            $this->contexts = [];
        } catch (Throwable $e) {
            $this->processException(new ResultNotStoppedException($fixture->getResultType(), $fixture->getUuid(), $e));
        }
        $this->notifier->afterFixtureStop($fixture);
    }

    public function getCurrentTestCase(): ?string
    {
        return $this->findRootContext();
    }

    public function getCurrentTestCaseOrStep(): ?string
    {
        return $this->findCurrentContext();
    }

    public function setCurrentTestCase(string $uuid): bool
    {
        try {
            $this->contexts = [
                $this
                    ->storage
                    ->getTest($uuid)
                    ->getUuid(),
            ];

            return true;
        } catch (Throwable $e) {
            $this->processException($e);

            return false;
        }
    }

    /**
     * @param TestResult  $test
     * @param string|null $containerUuid
     */
    public function scheduleTestCase(TestResult $test, ?string $containerUuid = null): void
    {
        $this->notifier->beforeTestSchedule($test);
        try {
            if (isset($containerUuid)) {
                $this
                    ->storage
                    ->getContainer($containerUuid)
                    ->addChildren($test->getUuid());
            }
            $this->storage->set(
                $test->setStage(Stage::scheduled()),
            );
        } catch (Throwable $e) {
            $this->processException(new TestNotScheduledException($test->getUuid(), $e));
        }
        $this->notifier->afterTestSchedule($test);
    }

    public function startTestCase(string $uuid): void
    {
        try {
            $test = $this->storage->getTest($uuid);
        } catch (Throwable $e) {
            $this->processException(new ResultNotStartedException(ResultType::test(), $uuid, $e));

            return;
        }
        $this->notifier->beforeTestStart($test);
        try {
            $this->contexts = [
                $test
                    ->setStage(Stage::running())
                    ->setStart($this->clock->now())
                    ->getUuid(),
            ];
        } catch (Throwable $e) {
            $this->processException(new ResultNotStartedException($test->getResultType(), $test->getUuid(), $e));
        }
        $this->notifier->afterTestStart($test);
    }

    public function updateTestCase(callable $update, ?string $uuid = null): void
    {
        try {
            $test = $this->storage->getTest(
                $uuid ?? $this->findRootContext() ?? throw new ActiveTestNotFoundException(),
            );
        } catch (Throwable $e) {
            $this->processException(new ResultNotUpdatedException(ResultType::test(), $uuid, $e));

            return;
        }
        $this->notifier->beforeTestUpdate($test);
        try {
            $update($test);
        } catch (Throwable $e) {
            $this->processException(new ResultNotUpdatedException($test->getResultType(), $test->getUuid(), $e));
        }
        $this->notifier->afterTestUpdate($test);
    }

    public function stopTestCase(string $uuid): void
    {
        try {
            $test = $this->storage->getTest(
                $this->findRootContext($uuid) ?? throw new ActiveTestNotFoundException(),
            );
        } catch (Throwable $e) {
            $this->processException(new ResultNotStoppedException(ResultType::test(), $uuid, $e));

            return;
        }
        $this->notifier->beforeTestStop($test);
        try {
            $test
                ->setStage(Stage::finished())
                ->setStop($this->clock->now());
            $this->contexts = [];
        } catch (Throwable $e) {
            $this->processException(new ResultNotStoppedException($test->getResultType(), $test->getUuid(), $e));
        }
        $this->notifier->afterTestStop($test);
    }

    public function writeTestCase(string $uuid): void
    {
        try {
            $test = $this->storage->getTest($uuid);
        } catch (Throwable $e) {
            $this->processException(new ResultNotWrittenException(ResultType::test(), $uuid, $e));

            return;
        }
        $this->notifier->beforeTestWrite($test);
        try {
            $this->resultsWriter->writeTest($test);
            $this->storage->unset($test->getUuid());
        } catch (Throwable $e) {
            $this->processException(new ResultNotWrittenException($test->getResultType(), $test->getUuid(), $e));
        }
        $this->notifier->afterTestWrite($test);
    }

    public function startStep(StepResult $step, ?string $parentUuid = null): AllureLifecycleInterface
    {
        $this->notifier->beforeStepStart($step);
        try {
            $parentContext = isset($parentUuid)
                ? $this->findContext($parentUuid)
                : $this->findCurrentContext();
            $this
                ->storage
                ->getStepsAware($parentContext ?? throw new ActiveStepNotFoundException())
                ->addSteps($step);
            $this
                ->storage
                ->set(
                    $step
                        ->setStage(Stage::running())
                        ->setStart($this->clock->now()),
                );
            $this->contexts[] = $step->getUuid();
        } catch (Throwable $e) {
            $this->processException(new ResultNotStartedException($step->getResultType(), $step->getUuid(), $e));
        }
        $this->notifier->afterStepStart($step);

        return $this;
    }

    public function updateStep(callable $update, ?string $uuid = null): void
    {
        try {
            $step = $this->storage->getStep(
                $uuid ?? $this->findCurrentNotRootContext() ?? throw new ActiveStepNotFoundException(),
            );
        } catch (Throwable $e) {
            $this->processException(new ResultNotUpdatedException(ResultType::step(), $uuid, $e));

            return;
        }
        $this->notifier->beforeStepUpdate($step);
        try {
            $update($step);
        } catch (Throwable $e) {
            $this->processException(new ResultNotUpdatedException($step->getResultType(), $step->getUuid(), $e));
        }
        $this->notifier->afterStepUpdate($step);
    }

    public function stopStep(?string $uuid = null): void
    {
        try {
            $step = $this->storage->getStep(
                // TODO: findNotRootContext?
                $this->findCurrentNotRootContext($uuid) ?? throw new ActiveStepNotFoundException(),
            );
        } catch (Throwable $e) {
            $this->processException(new ResultNotStoppedException(ResultType::step(), $uuid, $e));

            return;
        }
        $this->notifier->beforeStepStop($step);
        try {
            $step
                ->setStage(Stage::finished())
                ->setStop($this->clock->now());
            $this->storage->unset($step->getUuid());
            array_pop($this->contexts);
        } catch (Throwable $e) {
            $this->processException(new ResultNotStoppedException($step->getResultType(), $step->getUuid(), $e));
        }
        $this->notifier->afterStepStop($step);
    }

    public function addAttachment(Attachment $attachment, StreamFactoryInterface $data): void
    {
        try {
            $this->prepareAttachment($attachment);
        } catch (Throwable $e) {
            $this->processException(new AttachmentNotAddedException($attachment, $e));

            return;
        }
        $this->notifier->beforeAttachmentWrite($attachment);
        try {
            $this->resultsWriter->writeAttachment($attachment, $data);
        } catch (Throwable $e) {
            $this->processException(new AttachmentNotAddedException($attachment, $e));
        }
        $this->notifier->afterAttachmentWrite($attachment);
    }

    private function findContext(string $context): ?string
    {
        return in_array($context, $this->contexts, true)
            ? $context
            : null;
    }

    private function findRootContext(?string $context = null): ?string
    {
        $rootContext = $this->contexts[0] ?? null;
        if (!isset($rootContext)) {
            return null;
        }

        return isset($context) && $context != $rootContext
            ? null
            : $rootContext;
    }

    private function findCurrentNotRootContext(?string $context = null): ?string
    {
        $rootContext = $this->findRootContext();
        $currentContext = $this->findCurrentContext($context);

        return isset($rootContext, $currentContext) && $currentContext != $rootContext
            ? $currentContext
            : null;
    }

    private function findCurrentContext(?string $context = null): ?string
    {
        $currentContext = $this->contexts[count($this->contexts) - 1] ?? null;

        if (!isset($currentContext)) {
            return null;
        }

        return isset($context) && $context != $currentContext
            ? null
            : $currentContext;
    }

    private function prepareAttachment(Attachment $attachment): Attachment
    {
        $this
            ->storage
            ->getAttachmentsAware(
                $this->findCurrentContext() ?? throw new ActiveAttachmentContextNotFoundException(),
            )
            ->addAttachments($attachment);

        return $attachment;
    }
}
