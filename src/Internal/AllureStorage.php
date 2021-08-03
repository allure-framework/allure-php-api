<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\Internal\Exception\AttachmentsAwareNotFoundException;
use Qameta\Allure\Internal\Exception\ContainerNotFoundException;
use Qameta\Allure\Internal\Exception\FixtureNotFoundException;
use Qameta\Allure\Internal\Exception\StepNotFoundException;
use Qameta\Allure\Internal\Exception\StepsAwareNotFoundException;
use Qameta\Allure\Internal\Exception\TestCaseNotScheduledException;
use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\StorableInterface;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;
use Qameta\Allure\Model\UuidAwareInterface;

/**
 * @internal
 */
class AllureStorage implements AllureStorageInterface
{

    /**
     * @var array<string, StorableInterface>
     */
    private array $storage = [];

    public function set(UuidAwareInterface $object): void
    {
        $this->setByUuid($object->getUuid(), $object);
    }

    public function setByUuid(string $uuid, StorableInterface $object): void
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

    public function getStepsAware(string $uuid): StepsAwareStorableInterface
    {
        return $this->findObject(StepsAwareStorableInterface::class, $uuid)
            ?? throw new StepsAwareNotFoundException($uuid);
    }

    public function getAttachmentsAware(string $uuid): AttachmentsAwareStorableInterface
    {
        return $this->findObject(AttachmentsAwareStorableInterface::class, $uuid)
            ?? throw new AttachmentsAwareNotFoundException($uuid);
    }

    /**
     * @template T of StorableInterface
     * @param class-string<T> $class
     * @param string $uuid
     * @return StorableInterface|null
     * @psalm-return T|null
     */
    private function findObject(string $class, string $uuid): ?StorableInterface
    {
        $object = $this->storage[$uuid] ?? null;

        return $object instanceof $class ? $object : null;
    }
}
