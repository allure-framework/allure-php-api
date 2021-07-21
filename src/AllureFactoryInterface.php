<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Qameta\Allure\Internal\ResultFactoryInterface;

interface AllureFactoryInterface
{

    public function createLifecycle(AllureResultsWriterInterface $resultsWriter): AllureLifecycleInterface;

    public function createResultFactory(): ResultFactoryInterface;

    public function createResultsWriter(string $outputDirectory): AllureResultsWriterInterface;

    public function getStatusDetector(): StatusDetectorInterface;
}
