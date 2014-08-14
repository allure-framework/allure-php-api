<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Status;

class StepFailedEventTest extends StepStatusChangedEventTest
{
    /**
     * @return string
     */
    protected function getTestedStatus()
    {
        return Status::FAILED;
    }

    /**
     * @return StepEvent
     */
    protected function getStepEvent()
    {
        return new StepFailedEvent();
    }
}
