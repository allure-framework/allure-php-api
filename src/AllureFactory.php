<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Qameta\Allure\Internal\AllureStorage;
use Qameta\Allure\Internal\DefaultStatusDetector;
use Qameta\Allure\Internal\SystemClock;
use Qameta\Allure\Listener\LifecycleListenerInterface;
use Qameta\Allure\Internal\ListenersNotifierInterface;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;
use function array_values;

final class AllureFactory implements AllureFactoryInterface
{

    private ?UuidFactoryInterface $uuidFactory = null;

    private ?LoggerInterface $logger = null;

    private ?ClockInterface $clock = null;

    private ?ResultFactoryInterface $resultFactory = null;

    /**
     * @var list<LifecycleListenerInterface>
     */
    private array $lifecycleListeners = [];

    private ?StatusDetectorInterface $statusDetector = null;

    public function createLifecycle(AllureResultsWriterInterface $resultsWriter): AllureLifecycleInterface
    {
        return new AllureLifecycle(
            $this->getLogger(),
            $this->getClock(),
            $resultsWriter,
            new ListenersNotifierInterface($this->getLogger(), ...$this->lifecycleListeners),
            new AllureStorage(),
        );
    }

    public function setResultFactory(ResultFactoryInterface $resultFactory): self
    {
        $this->resultFactory = $resultFactory;

        return $this;
    }

    public function getResultFactory(): ResultFactoryInterface
    {
        return $this->resultFactory ??= new ResultFactory(
            $this->getUuidFactory(),
        );
    }

    public function addListeners(LifecycleListenerInterface $listener, LifecycleListenerInterface ...$moreListeners): self
    {
        $this->lifecycleListeners = [...$this->lifecycleListeners, $listener, ...array_values($moreListeners)];

        return $this;
    }

    public function createResultsWriter(string $outputDirectory): AllureResultsWriterInterface
    {
        return new FileSystemResultsWriter($outputDirectory, $this->getLogger());
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
