<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Qameta\Allure\ResultFactoryInterface;

interface AllureFactoryInterface
{

    public function createLifecycle(AllureResultsWriterInterface $resultsWriter): AllureLifecycleInterface;

    public function getResultFactory(): ResultFactoryInterface;

    public function createResultsWriter(string $outputDirectory): AllureResultsWriterInterface;

    public function getStatusDetector(): StatusDetectorInterface;
}
