<?php

namespace Yandex\Allure\Adapter\Event;

interface TestSuiteEvent extends Event {
    
    function getUuid();
    
}