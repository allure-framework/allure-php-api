<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Entity;
use Yandex\Allure\Adapter\Model\TestSuite;
use Yandex\Allure\Adapter\Support\Utils;

class TestSuiteFinishedEvent implements TestSuiteEvent {
    
    use Utils;

    /**
     * @var string
     */
    private $uuid;

    function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

    public function process(Entity $context)
    {
        if ($context instanceof TestSuite){
            $context->setStop(self::getTimestamp());
        }
    }

    function getUuid()
    {
        return $this->uuid;
    }

} 