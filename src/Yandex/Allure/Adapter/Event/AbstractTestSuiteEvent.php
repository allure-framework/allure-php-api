<?php

namespace Yandex\Allure\Adapter\Event;


use Yandex\Allure\Adapter\Support\Utils;

abstract class AbstractTestSuiteEvent implements TestSuiteEvent {
    
    use Utils;
    
    /**
     * @var string
     */
    private $uuid;

    function __construct()
    {
        $this->uuid = self::generateUUID();
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

} 