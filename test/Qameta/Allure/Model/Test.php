<?php

namespace Qameta\Allure;

use Qameta\Allure\Model\Label;
use Qameta\Allure\Model\Status;
use Qameta\Allure\Model\StepResult;
use Qameta\Allure\Model\TestResult;

class Test extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $tr = new TestResult();
        $tr
            ->setName('test')
            ->setStatus(Status::PASSED)
            ->setLabels([new Label('feature', 'F1')])
            ->setSteps([
                new StepResult('step 1'),
                new StepResult('step 2'),
                new StepResult('step 3'),
            ]);

        $res = json_encode($tr, JSON_PRETTY_PRINT);

        echo $res;
    }


}
