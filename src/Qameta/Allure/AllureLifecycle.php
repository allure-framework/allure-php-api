<?php

namespace Qameta\Allure;

use Qameta\Allure\Internal\AllureStorage;
use Qameta\Allure\Model\TestResult;
use RuntimeException;

/**
 * Class AllureLifecycle
 * @package Qameta\Allure
 */
class AllureLifecycle
{

    /**
     * @var AllureResultsWriter
     */
    private $writer;

    /**
     * @var AllureStorage
     */
    private $storage;

    /**
     * AllureLifecycle constructor.
     * @param AllureResultsWriter $writer
     */
    public function __construct(AllureResultsWriter $writer)
    {
        $this->writer = $writer;
        $this->storage = new AllureStorage();
    }

    /**
     * @param string $containerUuid
     * @param TestResult $testResult
     */
    public function scheduleTestCase(string $containerUuid, TestResult $testResult): void
    {
        if (!is_null($containerUuid)) {
            throw new RuntimeException('unsupported');
        }

        if (!isset($testResult) || is_null($testResult->getUuid())) {
            throw new RuntimeException('uuid should be specified');
        }

        $this->storage->set(
            $testResult->getUuid(),
            $testResult
        );
    }

    /**
     * @param string $uuid
     */
    public function startTestCase(string $uuid): void
    {
        $res = $this->storage->getTestResult($uuid);

        if (!isset($res)) {
            // should be scheduled at first place
            return;
        }

        $res->setStart(self::currentTimeMillis());

    }


    /**
     * @return int
     */
    private static function currentTimeMillis(): int
    {
        return intval(round(microtime(true) * 1000));
    }

}
