<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Status;

class TestCasePendingEventTest extends TestCaseStatusChangedEventTest
{
    /**
     * @return string
     */
    protected function getTestedStatus()
    {
        return Status::PENDING;
    }

    /**
     * @return TestCaseStatusChangedEvent
     */
    protected function getTestCaseStatusChangedEvent()
    {
        return new TestCasePendingEvent();
    }
}
