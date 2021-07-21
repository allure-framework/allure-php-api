<?php

declare(strict_types=1);

namespace Qameta\Allure\Listener;

use Qameta\Allure\Model\TestResult;

interface TestListener extends LifecycleListener
{

    public function beforeTestSchedule(TestResult $test): void;

    public function afterTestSchedule(TestResult $test): void;

    public function beforeTestStart(TestResult $test): void;

    public function afterTestStart(TestResult $test): void;

    public function beforeTestUpdate(TestResult $test): void;

    public function afterTestUpdate(TestResult $test): void;

    public function beforeTestStop(TestResult $test): void;

    public function afterTestStop(TestResult $test): void;

    public function beforeTestWrite(TestResult $test): void;

    public function afterTestWrite(TestResult $test): void;
}
