<?php

namespace Yandex\Allure\Adapter\Event;

use Yandex\Allure\Adapter\Model\Step;

class StepFinishedEventTest extends \PHPUnit_Framework_TestCase
{
    public function testEvent()
    {
        $step = new Step();
        $event = new StepFinishedEvent();
        $event->process($step);
        $this->assertNotEmpty($step->getStop());
    }
}
