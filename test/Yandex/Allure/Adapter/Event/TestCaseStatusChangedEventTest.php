<?php

namespace Yandex\Allure\Adapter\Event;

use Exception;
use Yandex\Allure\Adapter\Model\TestCase;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

abstract class TestCaseStatusChangedEventTest extends PhpUnitTestCase
{
    /**
     * @return string
     */
    abstract protected function getTestedStatus();

    /**
     * @return TestCaseStatusChangedEvent
     */
    abstract protected function getTestCaseStatusChangedEvent();

    public function testEvent()
    {
        $testMessage = 'test-message';
        $testCase = new TestCase();
        $event = $this->getTestCaseStatusChangedEvent();
        $event->withMessage($testMessage)->withException(new Exception());
        $event->process($testCase);

        $this->assertEquals($this->getTestedStatus(), $testCase->getStatus());
        $this->assertEquals($testMessage, $testCase->getFailure()->getMessage());
        $this->assertNotEmpty($testCase->getFailure()->getStackTrace());
    }
}
