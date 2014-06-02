<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Entity;

interface Event {
    
    function process(Entity $context);
    
} 