<?php

declare(strict_types=1);

namespace Qameta\Allure\Test\Io;

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use Qameta\Allure\Io\ExceptionThrowingLogger;
use RuntimeException;

/**
 * @covers \Qameta\Allure\Io\ExceptionThrowingLogger
 */
class ExceptionThrowingLoggerTest extends TestCase
{

    public function testEmergency_ConstructedWithEmergencyLevel_ThrowsException(): void
    {
        $logger = new ExceptionThrowingLogger(LogLevel::EMERGENCY);
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('a');
        $logger->emergency('a');
    }
}
