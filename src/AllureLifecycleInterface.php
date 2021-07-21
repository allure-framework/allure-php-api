<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;

interface AllureLifecycleInterface
{

    public function startTestContainer(ResultContainer $container, ?string $parentUuid = null): void;

    public function updateTestContainer(string $uuid, callable $update): void;

    public function stopTestContainer(string $uuid): void;

    public function writeTestContainer(string $uuid): void;

    public function startSetUpFixture(string $containerUuid, FixtureResult $fixture): void;

    public function startTearDownFixture(string $containerUuid, FixtureResult $fixture): void;

    public function updateFixture(callable $update, ?string $uuid = null): void;

    public function stopFixture(string $uuid): void;

    public function getCurrentTestCase(): ?string;

    public function getCurrentTestCaseOrStep(): ?string;

    public function setCurrentTestCase(string $uuid): bool;

    public function scheduleTestCase(TestResult $test, ?string $containerUuid = null): void;

    public function startTestCase(string $uuid): void;

    public function updateTestCase(callable $update, ?string $uuid = null): void;

    public function stopTestCase(string $uuid): void;

    public function writeTestCase(string $uuid): void;

    public function startStep(StepResult $step, ?string $parentUuid = null): AllureLifecycleInterface;

    public function updateStep(callable $update, ?string $uuid): void;

    public function stopStep(?string $uuid): void;

    public function addAttachment(string $name, ?string $type, ?string $fileExtension, StreamFactory $data): void;
}
