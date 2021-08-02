<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\Model\AttachmentsAware;
use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\StepsAware;
use Qameta\Allure\Model\Storable;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;
use Qameta\Allure\Model\UuidAware;

/**
 * @internal
 */
interface AllureStorageInterface
{

    public function set(UuidAware $object): void;

    public function setByUuid(string $uuid, Storable $object): void;

    public function unset(string $uuid): void;

    public function getContainer(string $uuid): ResultContainer;

    public function getFixture(string $uuid): FixtureResult;

    public function getTest(string $uuid): TestResult;

    public function getStep(string $uuid): StepResult;

    public function getStepsAware(string $uuid): StepsAware;

    public function getAttachmentsAware(string $uuid): AttachmentsAware;
}
