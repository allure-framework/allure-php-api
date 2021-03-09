<?php


namespace Qameta\Allure;

use Exception;
use Qameta\Allure\Model\TestResult;
use Ramsey\Uuid\Uuid;

/**
 * Class FileSystemResultsWriter
 * @package Qameta\Qameta\Allure
 */
class FileSystemResultsWriter implements AllureResultsWriter
{

    /**
     * @var string
     */
    private $outputDirectory;

    /**
     * FileSystemResultsWriter constructor.
     * @param string $outputDirectory
     */
    public function __construct(string $outputDirectory)
    {
        $this->outputDirectory = $outputDirectory;
    }

    /**
     * @inheritDoc
     */
    public function writeTestResult(TestResult $testResult): void
    {
        $fileName = self::generateTestResultFileName($testResult->getUuid());
        file_put_contents(
            $this->outputDirectory . DIRECTORY_SEPARATOR . $fileName,
            json_encode($testResult)
        );
    }

    private static function generateTestResultFileName(string $uuid = null): string
    {
        if (is_null($uuid)) {
            try {
                $uuid = Uuid::uuid4()->toString();
            } catch (Exception $e) {
                throw new AllureResultsWriteException("can't generate uuid for test result", $e);
            }
        }
        return "$uuid-testresult.json";
    }
}