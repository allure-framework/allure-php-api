<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Qameta\Allure\Model\Attachment;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;

interface AllureResultsWriterInterface
{

    public function writeContainer(ResultContainer $container): void;

    public function writeTest(TestResult $test): void;

    public function writeAttachment(Attachment $attachment, StreamFactoryInterface $data): void;

    public function write(string $target, StreamFactoryInterface $source): void;

    public function cleanOutputDirectory(): void;
}
