<?php


namespace Qameta\Allure;

use Qameta\Allure\Model\TestResult;

/**
 * Class AllureResultsWriter
 * @package Qameta\Qameta\Allure
 */
interface AllureResultsWriter
{

    /**
     * @param TestResult $testResult
     */
    public function writeTestResult(TestResult $testResult): void;

}
