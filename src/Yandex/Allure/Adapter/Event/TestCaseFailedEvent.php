<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Status;
use Yandex\Allure\Adapter\Support\Utils;

class TestCaseFailedEvent extends TestCaseStatusChangedEvent {
    
    /**
     * @return string
     */
    protected function getStatus()
    {
        return Status::FAILED;
    }

} 