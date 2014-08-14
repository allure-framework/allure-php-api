<?php

namespace Yandex\Allure\Adapter\Event\Storage;

use Yandex\Allure\Adapter\Model\Step;

class StepStorageTest extends \PHPUnit_Framework_TestCase
{
    const TEST_STEP_NAME = 'test-step';

    public function testEmptyStorage()
    {
        $storage = new Fixtures\MockedRootStepStorage();
        $this->assertTrue($storage->isRootStep($storage->getLast()));
        $this->assertTrue($storage->isRootStep($storage->pollLast()));
        $this->assertTrue($storage->isEmpty());
    }

    public function testNonEmptyStorage()
    {
        $storage = new Fixtures\MockedRootStepStorage();
        $step = new Step();
        $step->setName(self::TEST_STEP_NAME);
        $storage->put($step);
        $this->assertEquals($storage->getLast()->getName(), self::TEST_STEP_NAME);
    }
}
