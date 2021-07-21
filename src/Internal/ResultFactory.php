<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;
use Ramsey\Uuid\UuidFactoryInterface;

final class ResultFactory implements ResultFactoryInterface
{

    public function __construct(private UuidFactoryInterface $uuidFactory)
    {
    }

    public function createContainer(): ResultContainer
    {
        return new ResultContainer($this->createUuid());
    }

    public function createTest(): TestResult
    {
        return new TestResult($this->createUuid());
    }

    public function createStep(): StepResult
    {
        return new StepResult($this->createUuid());
    }

    public function createFixture(): FixtureResult
    {
        return new FixtureResult($this->createUuid());
    }

    private function createUuid(): string
    {
        return $this
            ->uuidFactory
            ->uuid4()
            ->toString();
    }
}
