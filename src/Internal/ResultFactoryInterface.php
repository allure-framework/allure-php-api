<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\Model\Attachment;
use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;

interface ResultFactoryInterface
{

    public function createContainer(): ResultContainer;

    public function createTest(): TestResult;

    public function createStep(): StepResult;

    public function createFixture(): FixtureResult;

    public function createAttachment(): Attachment;
}
