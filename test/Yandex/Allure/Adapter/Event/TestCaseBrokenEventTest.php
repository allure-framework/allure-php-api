<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Status;

class TestCaseBrokenEventTest extends TestCaseStatusChangedEventTest
{
    /**
     * @return string
     */
    protected function getTestedStatus()
    {
        return Status::BROKEN;
    }

    /**
     * @return TestCaseStatusChangedEvent
     */
    protected function getTestCaseStatusChangedEvent()
    {
        return new TestCaseBrokenEvent();
    }
}
