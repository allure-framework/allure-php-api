<?php


namespace Qameta\Allure;

use Qameta\Allure\Model\Attachment;
use Qameta\Allure\Model\TestResult;
use Qameta\Allure\Model\ResultContainer;
use Ramsey\Uuid\UuidFactoryInterface;

use function file_exists;
use function rtrim;

use const DIRECTORY_SEPARATOR;

/**
 * Class FileSystemResultsWriter
 * @package Qameta\Qameta\Allure
 */
class FileSystemResultsWriter implements AllureResultsWriterInterface
{

    private const ATTACHMENT_FILE_SUFFIX = '-attachment';

    /**
     * @var UuidFactoryInterface
     */
    private $uuidFactory;

    /**
     * @var string
     */
    private $outputDirectory;

    /**
     * FileSystemResultsWriter constructor.
     *
     * @param UuidFactoryInterface $uuidFactory
     * @param string               $outputDirectory
     */
    public function __construct(UuidFactoryInterface $uuidFactory, string $outputDirectory)
    {
        $this->uuidFactory = $uuidFactory;
        $this->outputDirectory = rtrim($outputDirectory, '\\/');
    }

    public function writeTest(TestResult $test): void
    {
        $this->write(
            "{$test->getUuid()}-result.json",
            AttachmentFactory::fromSerializable($test)
        );
    }

    public function writeContainer(ResultContainer $container): void
    {
        $this->write(
            "{$container->getUuid()}-container.json",
            AttachmentFactory::fromSerializable($container)
        );
    }

    public function writeAttachment(Attachment $attachment, StreamFactory $data): void
    {
        $this->write(
            $attachment->getSource(),
            $data,
        );
    }

    public function write(string $target, StreamFactory $source)
    {
        $closeResults = [];
        $sourceStream = $source->createStream();
        try {
            if ($this->shouldCreateOutputDirectory()) {
                $this->createOutputDirectory();
            }
            $file = $this->getRealOutputDirectory() . DIRECTORY_SEPARATOR . $target;
            $targetStream = $this->createTargetStream($file);
            try {
                $this->copyStream($sourceStream, $targetStream);
            } finally {
                \error_clear_last();
                $closeResult = @\fclose($targetStream);
                if (!$closeResult) {
                    $closeResults[] = \error_get_last();
                }
            }
        } finally {
            \error_clear_last();
            $closeResult = @\fclose($sourceStream);
            if (!$closeResult) {
                $closeResults[] = \error_get_last();
            }
        }
        $closeMessages = [];
        foreach ($closeResults as $closeResult) {
            if (isset($closeResult)) {
                $closeMessages[] = $closeResult['message'];
            }
        }
        if (!empty($closeMessages)) {
            $message = \implode(\PHP_EOL, $closeMessages);
        }
    }

    public function cleanOutputDirectory(): void
    {
        if ($this->shouldCreateOutputDirectory()) {
            return;
        }
        \error_clear_last();
        $files = @\scandir($this->outputDirectory);
        if (false === $files) {
            $error = \error_get_last();
            throw new \RuntimeException(
                "Failed to copy stream",
                0,
                isset($error) ? new \RuntimeException($error['message']) : null
            );
        }

        $deleteErrors = [];
        foreach ($files as $file) {
            $filePath = $this->outputDirectory . DIRECTORY_SEPARATOR . $file;
            if (\is_file($filePath)) {
                \error_clear_last();
                $isDeleted = @\unlink($filePath);
                if (!$isDeleted) {
                    $error = \error_get_last();
                    $deleteErrors[$filePath] = $error['message'] ?? null;
                }
            }
        }
        if (empty($deleteErrors)) {
            return;
        }
        $messages = ['Failed to delete some files in output directory:', ''];
        $index = 0;
        foreach ($deleteErrors as $filePath => $errorMessage) {
            $messages[] = "#{$index}: {$filePath}: {$errorMessage}";
            $index++;
        }
        throw new \RuntimeException(
            \implode(\PHP_EOL, $messages)
        );
    }

    public function createAttachmentSource(?string $fileExtension = null): string
    {
        $source = $this->uuidFactory->uuid4()->toString() . self::ATTACHMENT_FILE_SUFFIX;
        if (isset($fileExtension) && '' != $fileExtension) {
            $source .= '.' == $fileExtension[0] ? $fileExtension : '.' . $fileExtension;
        }

        return $source;
    }

    private function copyStream($sourceStream, $targetStream): void
    {
        \error_clear_last();
        $result = @\stream_copy_to_stream($sourceStream, $targetStream);
        $error = \error_get_last();
        if (isset($error)) {
            throw new \RuntimeException(
                "Failed to copy stream",
                0,
                new \RuntimeException($error['message'])
            );
        }

        if (false === $result) {
            throw new \RuntimeException("Failed to copy stream");
        }
    }

    /**
     * @param string $file
     * @return resource
     */
    private function createTargetStream(string $file)
    {
        \error_clear_last();
        $targetStream = @\fopen($file, 'w+b');
        $error = \error_get_last();
        if (isset($error)) {
            if (false !== $targetStream) {
                @\fclose($targetStream);
            }
            throw new \RuntimeException(
                "Failed to create target stream for {$file}",
                0,
                new \RuntimeException($error['message'])
            );
        }
        if (false === $targetStream) {
            throw new \RuntimeException("Failed to create target stream for {$file}");
        }

        return $targetStream;
    }

    private function getRealOutputDirectory(): string
    {
        \error_clear_last();
        $realDirectory = \realpath($this->outputDirectory);
        $error = \error_get_last();
        if (isset($error)) {
            throw new \RuntimeException(
                "Failed to resolve real path to {$this->outputDirectory}",
                0,
                new \RuntimeException($error['message'])
            );
        }
        if (false === $realDirectory) {
            throw new \RuntimeException("Failed to resolve real path to {$this->outputDirectory}");
        }

        return $realDirectory;
    }

    private function shouldCreateOutputDirectory(): bool
    {
        \error_clear_last();
        $dirExists = @file_exists($this->outputDirectory);
        $error = \error_get_last();
        if (isset($error)) {
            throw new \RuntimeException("Output failure: {$error['message']}");
        }
        if (!$dirExists) {
            return true;
        }

        \error_clear_last();
        $isDir = @\is_dir($this->outputDirectory);
        $error = \error_get_last();
        if (isset($error)) {
            throw new \RuntimeException("Output failure: {$error['message']}");
        }
        if ($isDir) {
            return false;
        }

        throw new \RuntimeException("Output failure: {$this->outputDirectory} is not a directory");
    }

    private function createOutputDirectory(): void
    {
        \error_clear_last();
        $isCreated = @\mkdir($this->outputDirectory, 0777, true);
        $error = \error_get_last();
        if (isset($error)) {
            throw new \RuntimeException(
                "Output failure: directory {$this->outputDirectory} is not created",
                0,
                new \RuntimeException($error['message'])
            );
        }
        if (!$isCreated) {
            throw new \RuntimeException("Output failure: directory {$this->outputDirectory} is not created");
        }
    }
}
