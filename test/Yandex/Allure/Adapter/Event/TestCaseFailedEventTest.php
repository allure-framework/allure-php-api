<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Status;

class TestCaseFailedEventTest extends TestCaseStatusChangedEventTest
{
    /**
     * @return string
     */
    protected function getTestedStatus()
    {
        return Status::FAILED;
    }

    /**
     * @return TestCaseStatusChangedEvent
     */
    protected function getTestCaseStatusChangedEvent()
    {
        return new TestCaseFailedEvent();
    }
}
