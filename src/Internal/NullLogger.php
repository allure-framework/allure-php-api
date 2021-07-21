<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Psr\Log\LoggerInterface;

final class NullLogger implements LoggerInterface
{

    public function alert($message, array $context = [])
    {
    }

    public function critical($message, array $context = [])
    {
    }

    public function debug($message, array $context = [])
    {
    }

    public function emergency($message, array $context = [])
    {
    }

    public function error($message, array $context = [])
    {
    }

    public function info($message, array $context = [])
    {
    }

    public function log($level, $message, array $context = [])
    {
    }

    public function notice($message, array $context = [])
    {
    }

    public function warning($message, array $context = [])
    {
    }
}
