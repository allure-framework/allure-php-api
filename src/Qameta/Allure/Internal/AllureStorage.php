<?php


namespace Qameta\Allure\Internal;

use Qameta\Allure\Model\FixtureResult;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\TestResultContainer;

/**
 * Class AllureStorage
 * @package Qameta\Allure\Internal
 */
class AllureStorage
{
    /**
     * @var array<string, mixed>
     */
    private $storage = array();

    /**
     * @param string $uuid
     * @return TestResult by given uuid if present, null otherwise.
     */
    public function getTestResult(string $uuid): TestResult
    {
        $res = $this->storage[$uuid];
        return isset($res) && $res instanceof TestResult ? $res : null;
    }

    /**
     * @param string $uuid
     * @return TestResultContainer by given uuid if present, null otherwise.
     */
    public function getTestResultContainer(string $uuid): TestResultContainer
    {
        $res = $this->storage[$uuid];
        return isset($res) && $res instanceof TestResultContainer ? $res : null;
    }

    /**
     * @param string $uuid
     * @return FixtureResult
     */
    public function getFixtureResult(string $uuid): FixtureResult
    {
        $res = $this->storage[$uuid];
        return isset($res) && $res instanceof FixtureResult ? $res : null;
    }

    /**
     * @param string $uuid
     * @return mixed
     */
    public function get(string $uuid)
    {
        return $this->storage[$uuid];
    }

    /**
     * @param string $uuid
     * @param $object
     */
    public function set(string $uuid, $object): void
    {
        return $this->storage[$uuid] = $object;
    }

}
