<?php

declare(strict_types=1);

namespace Qameta\Allure;

use Qameta\Allure\Model\Status;
use Qameta\Allure\Model\StatusDetails;
use Throwable;

final class DefaultStatusDetector implements StatusDetectorInterface
{

    public function getStatus(Throwable $error): ?Status
    {
        return null;
    }

    public function getStatusDetails(Throwable $error): ?StatusDetails
    {
        $errorClass = $error::class;
        $message =
            "{$error->getMessage()}\n" .
            "{$errorClass}({$error->getCode()}) in {$error->getFile()}:{$error->getLine()}";

        return new StatusDetails(
            message: $message,
            trace: $error->getTraceAsString(),
        );
    }
}
