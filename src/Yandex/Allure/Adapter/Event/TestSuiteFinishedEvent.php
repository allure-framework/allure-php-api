<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Entity;
use Yandex\Allure\Adapter\Model\TestSuite;
use Yandex\Allure\Adapter\Support\Utils;

class TestSuiteFinishedEvent extends AbstractTestSuiteEvent {
    
    use Utils;


    function __construct()
    {
        parent::__construct();
    }

    public function process(Entity $context)
    {
        if ($context instanceof TestSuite){
            $context->setStop(self::getTimestamp());
        }
    }

} 