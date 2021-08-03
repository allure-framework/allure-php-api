<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\Model\AttachmentsAwareInterface;
use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\StepsAwareInterface;
use Qameta\Allure\Model\StorableInterface;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;
use Qameta\Allure\Model\UuidAwareInterface;

/**
 * @internal
 */
interface AllureStorageInterface
{

    public function set(UuidAwareInterface $object): void;

    public function setByUuid(string $uuid, StorableInterface $object): void;

    public function unset(string $uuid): void;

    public function getContainer(string $uuid): ResultContainer;

    public function getFixture(string $uuid): FixtureResult;

    public function getTest(string $uuid): TestResult;

    public function getStep(string $uuid): StepResult;

    public function getStepsAware(string $uuid): StepsAwareInterface;

    public function getAttachmentsAware(string $uuid): AttachmentsAwareInterface;
}
