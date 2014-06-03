<?php

namespace Yandex\Allure\Adapter\Event;


use Yandex\Allure\Adapter\Model\Step;

abstract class StepStatusChangedEventTest extends \PHPUnit_Framework_TestCase {

    /**
     * @return string
     */
    protected abstract function getTestedStatus();

    /**
     * @return StepEvent
     */
    protected abstract function getStepEvent();
    
    public function testEvent()
    {
        $step = new Step();
        $event = $this->getStepEvent();
        $event->process($step);
        $this->assertEquals($this->getTestedStatus(), $step->getStatus());

    }
} 