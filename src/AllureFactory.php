<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Psr\Log\LoggerInterface;
use Qameta\Allure\Internal\AllureStorage;
use Qameta\Allure\Internal\ClockInterface;
use Qameta\Allure\DefaultStatusDetector;
use Qameta\Allure\Internal\ResultFactory;
use Qameta\Allure\Internal\ResultFactoryInterface;
use Qameta\Allure\Internal\NullLogger;
use Qameta\Allure\Internal\SystemClock;
use Qameta\Allure\Listener\LifecycleListener;
use Qameta\Allure\Listener\ListenersNotifier;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;

final class AllureFactory implements AllureFactoryInterface
{

    private ?UuidFactoryInterface $uuidFactory = null;

    private ?LoggerInterface $logger = null;

    private ?ClockInterface $clock = null;

    /**
     * @var list<LifecycleListener>
     */
    private array $lifecycleListeners = [];

    private ?StatusDetectorInterface $statusDetector = null;

    public function createLifecycle(AllureResultsWriterInterface $resultsWriter): AllureLifecycleInterface
    {
        return new AllureLifecycle(
            $this->getLogger(),
            $this->getClock(),
            $resultsWriter,
            new ListenersNotifier($this->getLogger(), ...$this->lifecycleListeners),
            new AllureStorage(),
        );
    }

    public function createResultFactory(): ResultFactoryInterface
    {
        return new ResultFactory(
            $this->getUuidFactory(),
        );
    }

    public function createResultsWriter(string $outputDirectory): AllureResultsWriterInterface
    {
        return new FileSystemResultsWriter($this->getUuidFactory(), $outputDirectory);
    }

    public function setStatusDetector(StatusDetectorInterface $statusDetector): self
    {
        $this->statusDetector = $statusDetector;

        return $this;
    }

    public function getStatusDetector(): StatusDetectorInterface
    {
        return $this->statusDetector ??= new DefaultStatusDetector();
    }

    public function setUuidFactory(UuidFactoryInterface $uuidFactory): self
    {
        $this->uuidFactory = $uuidFactory;

        return $this;
    }

    private function getUuidFactory(): UuidFactoryInterface
    {
        return $this->uuidFactory ??= new UuidFactory();
    }

    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    private function getLogger(): LoggerInterface
    {
        return $this->logger ??= new NullLogger();
    }

    public function setClock(ClockInterface $clock): AllureFactoryInterface
    {
        $this->clock = $clock;

        return $this;
    }

    private function getClock(): ClockInterface
    {
        return $this->clock ??= new SystemClock();
    }
}
