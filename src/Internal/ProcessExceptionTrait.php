<?php

declare(strict_types=1);

namespace Qameta\Allure\Internal;

use Psr\Log\LoggerInterface;
use Throwable;

/**
 * @internal
 */
trait ProcessExceptionTrait
{

    private ?LoggerInterface $logger = null;

    private function processException(Throwable $exception, array $context = []): void
    {
        if (!isset($this->logger)) {
            return;
        }
        $reasons = [];
        while (isset($exception)) {
            $reasons[] = "{$exception->getMessage()} in {$exception->getFile()}:{$exception->getLine()}";
            $exception = $exception->getPrevious();
        }
        $reason = implode("\n\nCaused by:\n", $reasons);
        $this->logger->error($reason, $context);
    }
}
