<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use JetBrains\PhpStorm\Pure;
use Qameta\Allure\Internal\Exception\AttachmentsAwareNotFoundException;
use Qameta\Allure\Internal\Exception\ContainerNotFoundException;
use Qameta\Allure\Internal\Exception\FixtureNotFoundException;
use Qameta\Allure\Internal\Exception\StepNotFoundException;
use Qameta\Allure\Internal\Exception\StepsAwareNotFoundException;
use Qameta\Allure\Internal\Exception\TestCaseNotScheduledException;
use Qameta\Allure\Model\AttachmentsAware;
use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\StepsAware;
use Qameta\Allure\Model\Storable;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;
use Qameta\Allure\Model\UuidAware;

/**
 * Class AllureStorage
 * @package Qameta\Allure\Internal
 */
class AllureStorage implements AllureStorageInterface
{

    /**
     * @var array<string, Storable>
     */
    private array $storage = [];

    public function set(UuidAware $object): void
    {
        $this->setByUuid($object->getUuid(), $object);
    }

    public function setByUuid(string $uuid, Storable $object): void
    {
        $this->storage[$uuid] = $object;
    }

    public function unset(string $uuid): void
    {
        unset($this->storage[$uuid]);
    }

    public function getContainer(string $uuid): ResultContainer
    {
        return $this->findObject(ResultContainer::class, $uuid)
            ?? throw new ContainerNotFoundException($uuid);
    }

    public function getFixture(string $uuid): FixtureResult
    {
        return $this->findObject(FixtureResult::class, $uuid)
            ?? throw new FixtureNotFoundException($uuid);
    }

    public function getTest(string $uuid): TestResult
    {
        return $this->findObject(TestResult::class, $uuid)
            ?? throw new TestCaseNotScheduledException($uuid);
    }

    public function getStep(string $uuid): StepResult
    {
        return $this->findObject(StepResult::class, $uuid)
            ?? throw new StepNotFoundException($uuid);
    }

    public function getStepsAware(string $uuid): StepsAware
    {
        return $this->findObject(StepsAware::class, $uuid)
            ?? throw new StepsAwareNotFoundException($uuid);
    }

    public function getAttachmentsAware(string $uuid): AttachmentsAware
    {
        return $this->findObject(AttachmentsAware::class, $uuid)
            ?? throw new AttachmentsAwareNotFoundException($uuid);
    }

    #[Pure]
    private function findObject(string $class, string $uuid): ?Storable
    {
        $object = $this->storage[$uuid] ?? null;

        return $object instanceof $class ? $object : null;
    }
}
