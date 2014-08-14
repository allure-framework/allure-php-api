<?php

namespace Yandex\Allure\Adapter\Support;

use Exception;
use Yandex\Allure\Adapter\Allure;
use Yandex\Allure\Adapter\Event\StepFailedEvent;
use Yandex\Allure\Adapter\Event\StepFinishedEvent;
use Yandex\Allure\Adapter\Event\StepStartedEvent;

class StepSupportTest extends \PHPUnit_Framework_TestCase
{
    use StepSupport;

    const STEP_NAME = 'step-name';
    const STEP_TITLE = 'step-title';

    /**
     * @var \Yandex\Allure\Adapter\Support\MockedLifecycle
     */
    private $mockedLifecycle;

    public function __construct()
    {
        $this->mockedLifecycle = new MockedLifecycle();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->mockedLifecycle = new MockedLifecycle();
        $this->getMockedLifecycle()->reset();
        Allure::setLifecycle($this->getMockedLifecycle());
    }

    public function testExecuteStepCorrectly()
    {
        $logicWithNoException = function () {
            //We do nothing, hence no error
        };
        $this->executeStep(self::STEP_NAME, $logicWithNoException, self::STEP_TITLE);
        $events = $this->getMockedLifecycle()->getEvents();
        $this->assertEquals(2, sizeof($events));
        $this->assertTrue($events[0] instanceof StepStartedEvent);
        $this->assertTrue($events[1] instanceof StepFinishedEvent);
    }

    /**
     * @expectedException Exception
     */
    public function testExecuteFailingStep()
    {
        $logicWithException = function () {
            throw new Exception();
        };
        $this->executeStep(self::STEP_NAME, $logicWithException, self::STEP_TITLE);
        $events = $this->getMockedLifecycle()->getEvents();
        $this->assertEquals(3, sizeof($events));
        $this->assertTrue($events[0] instanceof StepStartedEvent);
        $this->assertTrue($events[1] instanceof StepFailedEvent);
        $this->assertTrue($events[2] instanceof StepFinishedEvent);
    }

    /**
     * @expectedException \Yandex\Allure\Adapter\AllureException
     */
    public function testExecuteStepWithMissingData()
    {
        $this->executeStep(null, null, null);
    }

    protected function tearDown()
    {
        parent::tearDown();
        Allure::setDefaultLifecycle();
    }

    /**
     * @return MockedLifecycle
     */
    private function getMockedLifecycle()
    {
        return $this->mockedLifecycle;
    }
}
