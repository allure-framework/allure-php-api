<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Status;

class TestCaseCanceledEventTest extends TestCaseStatusChangedEventTest
{
    /**
     * @return string
     */
    protected function getTestedStatus()
    {
        return Status::CANCELED;
    }

    /**
     * @return TestCaseStatusChangedEvent
     */
    protected function getTestCaseStatusChangedEvent()
    {
        return new TestCaseCanceledEvent();
    }
}
