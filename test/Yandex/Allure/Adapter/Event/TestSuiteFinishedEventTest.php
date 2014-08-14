<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\TestSuite;

class TestSuiteFinishedEventTest extends \PHPUnit_Framework_TestCase
{
    public function testEvent()
    {
        $testSuite = new TestSuite();
        $event = new TestSuiteFinishedEvent('some-uuid');
        $event->process($testSuite);
        $this->assertNotEmpty($testSuite->getStop());
    }
}
