<?php

declare(strict_types=1);

namespace Qameta\Allure\Io;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use ReflectionClass;
use ReflectionClassConstant;
use RuntimeException;

use function array_flip;
use function array_map;
use function array_values;
use function is_string;

final class ExceptionThrowingLogger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var array<string, int>
     */
    private array $logLevels;

    private LoggerInterface $delegate;

    public function __construct(
        private string $thresholdLevel = LogLevel::WARNING,
        ?LoggerInterface $delegate = null,
    ) {
        $this->delegate = $delegate ?? new NullLogger();
        $this->logLevels = $this->setupLogLevels();
    }

    /**
     * @return array<string, int>
     */
    private function setupLogLevels(): array
    {
        $logLevelsRef = new ReflectionClass(LogLevel::class);

        return array_flip(
            array_map(
                fn (mixed $value): string => (string) $value,
                array_values(
                    $logLevelsRef->getConstants(ReflectionClassConstant::IS_PUBLIC),
                ),
            ),
        );
    }

    public function log(mixed $level, $message, array $context = []): void
    {
        $this->delegate->log($level, $message, $context);
        if ($this->shouldThrowException($level)) {
            throw new RuntimeException($message);
        }
    }

    private function shouldThrowException(mixed $level): bool
    {
        if (!is_string($level)) {
            return false;
        }

        $currentLevel = $this->logLevels[$level] ?? null;
        $thresholdLevel = $this->logLevels[$this->thresholdLevel] ?? null;

        return isset($currentLevel, $thresholdLevel) && $currentLevel <= $thresholdLevel;
    }
}
