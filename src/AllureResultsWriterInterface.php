<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Qameta\Allure\Model\Attachment;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;

interface AllureResultsWriterInterface
{

    public function writeContainer(ResultContainer $container): void;

    public function writeTest(TestResult $result): void;

    public function writeAttachment(Attachment $attachment, StreamFactory $data): void;

    public function write(string $target, StreamFactory $source);

    public function cleanOutputDirectory(): void;

    public function createAttachmentSource(?string $fileExtension = null): string;
}
