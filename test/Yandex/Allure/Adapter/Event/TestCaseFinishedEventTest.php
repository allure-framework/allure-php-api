<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\TestCase;

class TestCaseFinishedEventTest extends \PHPUnit_Framework_TestCase
{
    public function testEvent()
    {
        $testCase = new TestCase();
        $event = new TestCaseFinishedEvent();
        $event->process($testCase);
        $this->assertNotEmpty($testCase->getStop());
    }
}
