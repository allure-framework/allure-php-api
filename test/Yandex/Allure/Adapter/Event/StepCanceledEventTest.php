<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Status;

class StepCanceledEventTest extends StepStatusChangedEventTest
{
    /**
     * @return string
     */
    protected function getTestedStatus()
    {
        return Status::CANCELED;
    }

    /**
     * @return StepEvent
     */
    protected function getStepEvent()
    {
        return new StepCanceledEvent();
    }
}
