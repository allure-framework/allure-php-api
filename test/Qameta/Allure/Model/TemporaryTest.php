<?php

namespace Qameta\Allure\Model;

use PHPUnit\Framework\TestCase;

class TemporaryTest extends TestCase
{
    public function testName()
    {
        self::markTestSkipped("Debug test");
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
